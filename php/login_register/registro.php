<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../conexion/conexion.php");

// Clave secreta para encriptar y desencriptar
$encryption_key = 'clave_secreta'; // Debe ser segura y manejada con cuidado

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar la entrada
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // Contraseña sin encriptar
    $id_rol = filter_var($_POST['id_rol'], FILTER_VALIDATE_INT);

    // Verificar si el correo ya existe en la base de datos
    $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = :correo");
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Si el correo ya existe, mostrar una alerta y redirigir
        echo "<script>alert('No se pudo agregar porque el correo {$correo} pertenece a alguien más.'); window.location.href='../../views/registro.php';</script>";
        exit();
    }

    // Encriptar la contraseña
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')); // Genera un IV aleatorio
    $password_encriptada = openssl_encrypt($password, 'aes-256-cbc', $encryption_key, 0, $iv);
    $password_encriptada = base64_encode($iv . $password_encriptada); // Combina IV y contraseña encriptada

    // Establecer el valor de tp_password en 2
    $tp_password = 2;

    // Preparar y ejecutar la consulta para insertar un nuevo usuario
    $stmt = $conexion->prepare("INSERT INTO usuarios (correo, password, nombre, id_rol, tp_password) VALUES (:correo, :password, :nombre, :id_rol, :tp_password)");
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $password_encriptada);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':id_rol', $id_rol);
    $stmt->bindParam(':tp_password', $tp_password);

    if ($stmt->execute()) {
        // Si la inserción es exitosa, mostrar una alerta y redirigir
        echo "<script>alert('Registro exitoso.'); window.location.href='../admin/dasboard.php';</script>";
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>
