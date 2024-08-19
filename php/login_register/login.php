<?php
include("../../conexion/conexion.php");
include("../../includes/alertas.php");

session_start();

// Clave secreta para desencriptar
$encryption_key = 'clave_secreta'; // Debe ser segura y manejada con cuidado

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password']; // Contraseña sin encriptar

    // Consulta para verificar si el correo existe
    $stmt = $conexion->prepare('SELECT correo, id_rol, password, tp_password FROM usuarios WHERE correo = ?');
    $stmt->execute([$correo]);
    $user = $stmt->fetch(); 

    // Verificar si el correo existe
    if ($user) {
        // Desencriptar la contraseña almacenada
        $stored_password = base64_decode($user['password']);
        $iv_length = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($stored_password, 0, $iv_length);
        $encrypted_data = substr($stored_password, $iv_length);
        $password_desencriptada = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);

        // Verificar si la contraseña proporcionada coincide con la desencriptada
        if ($password_desencriptada && hash_equals($password, $password_desencriptada)) {
            // Verificar si el tp_password es 2
            if ($user['tp_password'] == 2) {
                $_SESSION['correo'] = $user['correo']; // Asegúrate de que la sesión esté creada
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
                        toastr.warning("Por su seguridad, debe cambiar su contraseña.", "Advertencia");
                    });
                  </script>';
                header('Location: procesar_cambio_contrasena.php');
                exit;
            }

            $_SESSION['correo'] = $user['correo'];
            $_SESSION['id_rol'] = $user['id_rol'];

            // Redirigir según el id_rol
            if ($user['id_rol'] == 1) {
                header('Location: ../admin/dasboard.php');
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
