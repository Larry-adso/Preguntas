<?php
require '../../conexion/conexion.php';

$clasificacion = $_GET['clasificacion'];

$stmt = $conexion->prepare("SELECT cuestionario.id, clasificacion.clasificacion, cuestionario.pregunta, cuestionario.respuesta 
                            FROM cuestionario 
                            JOIN clasificacion ON cuestionario.id_clasificacion = clasificacion.id 
                            WHERE clasificacion.clasificacion = ?");
$stmt->execute([$clasificacion]);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['clasificacion'] . "</td>";
    echo "<td>" . $row['pregunta'] . "</td>";
    echo "<td>" . $row['respuesta'] . "</td>";
    echo "<td>";
    echo "<a href='editar.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Editar</a> ";
    echo "<a href='eliminar.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Eliminar</a>";
    echo "</td>";
    echo "</tr>";
}
?>
