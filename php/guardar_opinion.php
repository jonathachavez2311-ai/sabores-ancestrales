<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = $_POST["nombre"] ?? '';
    $apellido = $_POST["apellido"] ?? '';
    $comentario = $_POST["comentario"] ?? ''; 

    $sql = "INSERT INTO opiniones (nombre, apellido, comentario)
            VALUES ('$nombre', '$apellido', '$comentario')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Opinión enviada correctamente');
                window.location.href='../opiniones.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error al guardar la opinión: " . $conn->error . "');
                window.history.back();
              </script>";
    }

    $conn->close();
}
?>
