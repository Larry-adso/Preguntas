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
    <title>Dashboard</title>
    <!-- Agregar Bootstrap CSS o cualquier otro framework que prefieras -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Dashboard</h1>
            <a href="../login_register/cerrar.php" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10 15a1 1 0 0 0 1-1v-3H5.5a.5.5 0 0 1 0-1H11v-3a1 1 0 1 0-2 0v3H5.5a.5.5 0 0 1 0-1H9V6a1 1 0 0 0-2 0v3H5.5a.5.5 0 0 1 0-1H8V5a1 1 0 1 0-2 0v4H5.5a.5.5 0 0 1 0-1H7V5a1 1 0 0 0-2 0v5H5.5a.5.5 0 0 1 0-1H6V5a1 1 0 1 0-2 0v6a1 1 0 0 0 1 1v3a1 1 0 0 0 1 1h5z"/>
                  <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h6.293l-2.147-2.146a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L11.293 8.5H5a.5.5 0 0 1-.5-.5z"/>
                </svg>
                Cerrar Sesión
            </a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <a href="../excel/subir.php" class="btn btn-primary btn-block">Subir Documento</a>
            </div>
            <div class="col-md-6">
                <a href="../../views/registro.php" class="btn btn-secondary btn-block">Registrar Usuarios</a>
            </div>
        </div>
    </div>

    <!-- Agregar Bootstrap JS o cualquier otro framework que prefieras -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
