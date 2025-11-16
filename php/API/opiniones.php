<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

include_once('../conexion.php');

$method = $_SERVER['REQUEST_METHOD'];
$response = [];

if ($method === 'GET') {
    $query = "SELECT * FROM opiniones ORDER BY fecha_registro DESC";
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $response = ['success' => true, 'data' => $data];
}
elseif ($method === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input) $input = $_POST;

    $nombre = $input['nombre'] ?? '';
    $apellido = $input['apellido'] ?? '';
    $comentario = $input['comentario'] ?? '';

    $stmt = $conn->prepare("INSERT INTO opiniones (nombre, apellido, comentario) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $apellido, $comentario);

    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Opinión registrada correctamente'];
    } else {
        $response = ['success' => false, 'message' => 'Error al guardar opinión'];
    }
}
else {
    http_response_code(405);
    $response = ['success' => false, 'message' => 'Método no permitido'];
}

echo json_encode($response);
?>