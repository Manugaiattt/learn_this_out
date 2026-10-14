<?php
// groq_proxy.php — intermediario entre el navegador y la API de Groq.
// La API key nunca sale del servidor.
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store");

function fail($code, $msg, $type = 'error') {
    http_response_code($code);
    echo json_encode(["error" => ["message" => $msg, "code" => $type]]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail(405, "Método no permitido.");
}

$config = require __DIR__ . '/groq_config.php';

if (empty($config['api_key']) || $config['api_key'] === 'PEGA_ACA_TU_NUEVA_CLAVE') {
    fail(500, "Falta configurar la API key en groq_config.php.");
}

// ── Autenticación: token de sesión generado por login.php / register.php ──
if (!empty($config['require_login'])) {
    $token = $_SERVER['HTTP_X_AUTH_TOKEN'] ?? '';
    if ($token === '') {
        fail(401, "No hay sesión iniciada.", 'session_invalid');
    }

    require_once __DIR__ . '/db_connect.php';

    $hashed = hash('sha256', $token);
    $stmt = $conn->prepare("SELECT (token_expires_at IS NOT NULL AND token_expires_at > NOW()) AS vigente FROM users WHERE session_token = ? LIMIT 1");
    $stmt->bind_param("s", $hashed);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $conn->close();

    if (!$row) {
        fail(401, "Tu sesión ya no es válida (puede que hayas iniciado sesión en otro navegador o dispositivo). Volvé a iniciar sesión.", 'session_invalid');
    }
    if (!(int)$row['vigente']) {
        fail(401, "Tu sesión venció. Volvé a iniciar sesión.", 'session_invalid');
    }
}

// ── Validación del pedido (el cliente NO elige modelo ni pasa parámetros libres) ──
$in = json_decode(file_get_contents("php://input"), true);
if (!is_array($in) || !isset($in['messages']) || !is_array($in['messages'])) {
    fail(400, "Pedido inválido.");
}

$messages = [];
$totalChars = 0;
foreach (array_slice($in['messages'], 0, 4) as $m) {
    $role = $m['role'] ?? '';
    $content = $m['content'] ?? '';
    if (!in_array($role, ['user', 'system'], true) || !is_string($content) || $content === '') {
        fail(400, "Mensaje inválido.");
    }
    $totalChars += mb_strlen($content);
    $messages[] = ["role" => $role, "content" => $content];
}
if (!$messages || $totalChars > 30000) {
    fail(413, "El texto enviado es demasiado largo.");
}

$effort = $in['reasoning_effort'] ?? 'low';
if (!in_array($effort, ['low', 'medium', 'high'], true)) $effort = 'low';

$payload = [
    "model"                 => $config['model'],
    "messages"              => $messages,
    "max_completion_tokens" => max(1, min((int)($in['max_tokens'] ?? 2048), 4096)),
    "temperature"           => max(0, min((float)($in['temperature'] ?? 0.3), 1)),
    "reasoning_effort"      => $effort,
];

// ── Llamada a Groq ──
$retryAfter = null;
$ch = curl_init("https://api.groq.com/openai/v1/chat/completions");
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => [
        "Content-Type: application/json",
        "Authorization: Bearer " . $config['api_key'],
    ],
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 90,
    CURLOPT_HEADERFUNCTION => function ($ch, $line) use (&$retryAfter) {
        if (stripos($line, 'retry-after:') === 0) {
            $retryAfter = trim(substr($line, 12));
        }
        return strlen($line);
    },
]);

$body   = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$cerr   = curl_error($ch);
curl_close($ch);

if ($body === false) {
    fail(502, "No se pudo conectar con Groq: " . $cerr);
}

// Si Groq rechaza la clave, NO lo reportamos como 401 (eso lo usa el cliente para "sesión vencida")
if ($status === 401 || $status === 403) {
    $j = json_decode($body, true);
    $detalle = $j['error']['message'] ?? '';
    fail(502, "Groq rechazó la API key o el acceso al modelo (revisá groq_config.php). " . $detalle, 'upstream_auth');
}

if ($retryAfter !== null) {
    header("Retry-After: " . $retryAfter);
}
http_response_code($status ?: 502);
echo $body;
