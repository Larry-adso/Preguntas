<?php
include("../../conexion/conexion.php");
include("../../includes/alertas.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];
   $password = hash('sha512', $password);

    // Consulta para verificar si el correo existe
    $stmt = $conexion->prepare('SELECT  correo, id_rol, password FROM usuarios WHERE correo = ?');
    $stmt->execute([$correo]);
    $user = $stmt->fetch(); 

    // Verificar si el correo existe
    if ($user) {
        // Verificar si la contraseña es correcta
        if ($user['password'] === $password) {
            $_SESSION['correo'] = $user['correo'];
            $_SESSION['id_rol'] = $user['id_rol'];

            // Redirigir según el id_rol
            if ($user['id_rol'] == 1) {
                header('Location: ../dasboard.php');
            } elseif ($user['id_rol'] == 2) {
                header('Location: ../../views/index.php');
            }
            exit;
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
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.error("Correo o contraseña incorrectos.", "Error de autenticación");
                    setTimeout(function() {
                        window.location = "../../index.php";
                    }, 1000);
                });
              </script>';
        }
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
                toastr.error("El correo no se encuentra registrado.", "Error de autenticación");
                setTimeout(function() {
                    window.location = "../../index.php";
                }, 2000);
            });
          </script>';
    }
}
?>