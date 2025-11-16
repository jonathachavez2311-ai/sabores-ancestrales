<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = $_POST["nombre"] ?? '';
    $apellido = $_POST["apellido"] ?? '';
    $calificacion = $_POST["calificacion"] ?? '';
    $comentario = $_POST["comentario"] ?? '';

    $sql = "INSERT INTO valoraciones (nombre, apellido, calificacion, comentario)
            VALUES ('$nombre', '$apellido', '$calificacion', '$comentario')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Valoración enviada correctamente');
                window.location.href='../valoracion.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error al guardar la valoración: " . $conn->error . "');
                window.history.back();
              </script>";
    }

    $conn->close();
}
?>
