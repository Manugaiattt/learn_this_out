<?php
// register.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

$username = isset($data['username']) ? trim($data['username']) : '';
$email    = isset($data['email']) ? trim($data['email']) : '';
$password = isset($data['password']) ? trim($data['password']) : '';

if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Todos los campos obligatorios deben completarse."]);
    exit();
}

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR (email != '' AND email = ?)");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["status" => "error", "message" => "El usuario o correo ya está registrado."]);
    $stmt->close();
    exit();
}
$stmt->close();

$password_hash = password_hash($password, PASSWORD_BCRYPT);
$token = bin2hex(random_bytes(32));
$hashedToken = hash('sha256', $token);
$expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, session_token, token_expires_at) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $username, $email, $password_hash, $hashedToken, $expiresAt);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "success" => true,
        "message" => "Registro exitoso.",
        "token" => $token,
        "username" => $username,
        "email" => $email
    ]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error al registrar el usuario."]);
}

$stmt->close();
$conn->close();
?>