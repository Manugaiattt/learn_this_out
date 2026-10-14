<?php
// login.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

// Manejo de la petición Preflight del navegador
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
    exit;
}

require_once "db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$user = isset($data['user']) ? trim($data['user']) : '';
$pass = isset($data['pass']) ? trim($data['pass']) : '';

if (empty($user) || empty($pass)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Faltan credenciales."]);
    exit;
}

$stmt = $conn->prepare("SELECT id, username, email, password_hash FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $user, $user);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($pass, $row['password_hash'])) {
        $token = bin2hex(random_bytes(32));
        $hashedToken = hash('sha256', $token);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        $updateStmt = $conn->prepare("UPDATE users SET session_token = ?, token_expires_at = ? WHERE id = ?");
        $updateStmt->bind_param("ssi", $hashedToken, $expiresAt, $row['id']);
        $updateStmt->execute();
        $updateStmt->close();

        echo json_encode([
            "status" => "success",
            "success" => true,
            "message" => "Inicio de sesión exitoso.",
            "user" => [
                "id" => (int)$row['id'],
                "username" => $row['username'],
                "email" => $row['email'],
                "token" => $token
            ]
        ]);
        
        $stmt->close();
        $conn->close();
        exit;
    }
}

http_response_code(401);
echo json_encode(["status" => "error", "message" => "Usuario o contraseña incorrectos."]);

$stmt->close();
$conn->close();
?>