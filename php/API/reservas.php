<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

include_once('../conexion.php');

$method = $_SERVER['REQUEST_METHOD'];
$response = [];

if ($method === 'GET') {
    $query = "SELECT * FROM reservas ORDER BY fecha_registro DESC";
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
    $email = $input['email'] ?? '';
    $telefono = $input['telefono'] ?? '';
    $fecha = $input['fecha'] ?? null;
    $hora = $input['hora'] ?? null;
    $personas = $input['personas'] ?? null;
    $mensaje = $input['mensaje'] ?? '';

    $stmt = $conn->prepare("INSERT INTO reservas (nombre, apellido, email, telefono, fecha, hora, personas, mensaje) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $telefono, $fecha, $hora, $personas, $mensaje);

    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Reserva registrada correctamente'];
    } else {
        $response = ['success' => false, 'message' => 'Error al guardar reserva'];
    }
}
else {
    http_response_code(405);
    $response = ['success' => false, 'message' => 'Método no permitido'];
}

echo json_encode($response);
?>