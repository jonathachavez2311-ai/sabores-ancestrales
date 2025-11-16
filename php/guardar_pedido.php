<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pedido = $_POST['pedido'] ?? '';
    $total = $_POST['total'] ?? '';
    $pago = $_POST['pago'] ?? '';

    if (!empty($pedido) && !empty($total) && !empty($pago)) {
        $fecha = date("Y-m-d H:i:s");
        $sql = "INSERT INTO pedidos (detalle, total, metodo_pago, fecha) VALUES ('$pedido', '$total', '$pago', '$fecha')";
        
        if ($conn->query($sql) === TRUE) {
            echo "✅ Pedido guardado correctamente";
        } else {
            echo "Error al guardar: " . $conn->error;
        }
    } else {
        echo "❌ Datos incompletos.";
    }
}

$conn->close();
?>
