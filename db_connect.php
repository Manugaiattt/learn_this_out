<?php
// db.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "learn_this_out";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error de conexión a la base de datos."]);
    exit;
}

mysqli_set_charset($conn, "utf8mb4");
?>