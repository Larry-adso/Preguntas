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
include("../../conexion/conexion.php");
include("../../includes/alertas.php");

session_start();

// Clave secreta para encriptar
$encryption_key = 'clave_secreta'; // Debe ser segura y manejada con cuidado

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_SESSION['correo']; // Obtener el correo del usuario logueado
    $nueva_contraseña = $_POST['nueva_contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    // Verificar si las contraseñas coinciden
    if ($nueva_contraseña !== $confirmar_contraseña) {
        echo '<script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-center-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.error("Las contraseñas no coinciden.", "Error");
            });
        </script>';
        exit;
    }

    // Encriptar la nueva contraseña
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')); // Genera un IV aleatorio
    $password_encriptada = openssl_encrypt($nueva_contraseña, 'aes-256-cbc', $encryption_key, 0, $iv);
    $password_encriptada = base64_encode($iv . $password_encriptada); // Combina IV y contraseña encriptada

    // Actualizar la contraseña y el tp_password en la base de datos
    $stmt = $conexion->prepare("UPDATE usuarios SET password = :password, tp_password = 1 WHERE correo = :correo");
    $stmt->bindParam(':password', $password_encriptada);
    $stmt->bindParam(':correo', $correo);

    if ($stmt->execute()) {
        echo '<script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-center-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.success("Contraseña actualizada con éxito.", "Éxito");
                setTimeout(function() {
                    window.location.href = "../../index.php";
                }, 2000);
            });
        </script>';
    } else {
        echo '<script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-center-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.error("Hubo un problema al actualizar la contraseña.", "Error");
            });
        </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="../../css/recuperar.css">
</head>
<body>
    <div class="container">
        <h2>Cambiar Contraseña</h2>
        <form method="POST">
            <div class="input-group">
                <label for="nueva_contraseña">Nueva Contraseña:</label>
                <input type="password" id="nueva_contraseña" name="nueva_contraseña" required>
            </div>
            <div class="input-group">
                <label for="confirmar_contraseña">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contraseña" name="confirmar_contraseña" required>
            </div>
            <div class="button-group">
                <input type="submit" value="Cambiar Contraseña">
            </div>
        </form>
    </div>
</body>
</html>

