<?php
session_start();

if (!isset($_SESSION['correo'])) {
  echo '
    <script>
        alert("Por favor inicie sesión e intente nuevamente");
        window.location = "../../index.php";
    </script>
    ';
  session_destroy();
  die();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir y Procesar Archivo Excel</title>
    <link rel="stylesheet" href="../../css/subir.css">
</head>
<body>

<div class="form-container">
    <form id="excel-form" action="upload.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Selecciona un archivo Excel:</label>
            <input type="file" name="file" id="file" accept=".xls,.xlsx" required>
        </div>
        <input type="submit" value="Subir Archivo">
    </form>
</div>

</body>
</html>
