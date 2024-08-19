<?php
require '../../conexion/conexion.php'; // Asegúrate de que esta ruta sea correcta para tu archivo de conexión

try {
    // Preparar la consulta para eliminar todos los registros de la tabla `cuestionario`
    $stmt = $conexion->prepare("DELETE FROM cuestionario");

    // Ejecutar la consulta
    $stmt->execute();

    // Redirigir a la página principal o mostrar un mensaje de éxito
    header('Location: dasboard.php'); // Redirige a la página principal después de la eliminación
    exit();
} catch (PDOException $e) {
    // En caso de error, mostrar un mensaje
    echo "Error al borrar los registros: " . $e->getMessage();
}
?>
