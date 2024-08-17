<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;



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

$envPath = __DIR__ . '/.env';
if (!file_exists($envPath)) {
    die("Archivo .env no encontrado en la ruta: $envPath");
}

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();


// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar la entrada
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // Esta es la contraseña sin encriptar
    $password_encriptada = hash('sha512', $password);
    $id_rol = filter_var($_POST['id_rol'], FILTER_VALIDATE_INT);

    // Preparar y ejecutar la consulta para insertar un nuevo usuario
    $stmt = $conexion->prepare("INSERT INTO usuarios (correo, password, nombre, id_rol) VALUES (:correo, :password, :nombre, :id_rol)");
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $password_encriptada);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':id_rol', $id_rol);

    if ($stmt->execute()) {
        // Si el registro es exitoso, enviar correo al usuario
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];  // Especifica el servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USERNAME'];  // Tu dirección de correo
            $mail->Password = $_ENV['SMTP_PASSWORD'];  // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SMTP_PORT'];  // Puerto TCP

            // Destinatarios
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'HostDime');
            $mail->addAddress($correo, $nombre);  // Añadir destinatario

            // Contenido del correo
            $mail->isHTML(true);  // Configurar correo como HTML
            $mail->Subject = 'Registro exitoso en HostDime Andicom 2024';
            $mail->Body = "
            Hola $nombre,<br><br>

            Te comento que este es su usuario y contraseña para acceder al sitio de preguntas HostDime Andicom-2024:<br><br>

            Usuario: $correo<br>
            Contraseña: $password (sin encriptar)<br><br>

            Puedes acceder al sitio usando el siguiente enlace:<br>
            <a href='https://ar.pinterest.com/sofiajuani2477/fotos-de-perritos-tiernos/'>Acceder al sitio</a><br><br>

            Quien lo envía es: garcialarry0338@gmail.com<br><br>

            ¡Bienvenido!
            ";

            $mail->send();
            echo 'Registro exitoso. Un correo ha sido enviado con tus credenciales.';
        } catch (Exception $e) {
            echo "Registro exitoso, pero no se pudo enviar el correo. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error al registrar el usuario.";
    }
}


