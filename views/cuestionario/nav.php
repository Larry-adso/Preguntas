<?php 
$hostdime_id = 1;
$datacenter_id = 2;
$nebula_id = 3;
$certificaciones_id = 4;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navegación Responsive</title>
    <link rel="stylesheet" href="../../css/nv.css">
</head>
<body>
    <nav>
        <ul class="nav-list">
            <li><a href="hostdime.php?id_clasificacion=<?php echo $hostdime_id; ?>">HostDime</a></li>
            <li><a href="datacenter.php?id_clasificacion=<?php echo $datacenter_id; ?>">DataCenter</a></li>
            <li><a href="nebula.php?id_clasificacion=<?php echo $nebula_id; ?>">Nebula</a></li>
            <li><a href="certificaciones.php?id_clasificacion=<?php echo $certificaciones_id; ?>">Certificaciones</a></li>
        </ul>
    </nav>
</body>
</html>
