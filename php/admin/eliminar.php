<?php
require '../../conexion/conexion.php';

$id = $_GET['id'];
$stmt = $conexion->prepare("DELETE FROM cuestionario WHERE id = ?");
$stmt->execute([$id]);

echo '
<script>
    alert("Eliminado Correctamente");
    window.location.href = "dasboard.php";
</script>
';
?>
