<?php
require '../../conexion/conexion.php'; // Asegúrate de que la ruta es correcta
require '../../vendor/autoload.php'; // Asegúrate de que la ruta a Composer autoload es correcta

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Clave secreta para desencriptar
$encryption_key = 'clave_secreta'; // Debe ser segura y manejada con cuidado

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Crear nuevo Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$sheet->setCellValue('A1', 'Correo');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Contraseña');

// La conexión a la base de datos ya está incluida y activa
// Obtener usuarios con id_rol = 2
$query = $conexion->query("SELECT correo, nombre, password FROM usuarios WHERE id_rol = 2");
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

// Llenar datos en el Excel
$row = 2;
foreach ($usuarios as $usuario) {
    // Desencriptar la contraseña
    $stored_password = base64_decode($usuario['password']);
    $iv = substr($stored_password, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted_data = substr($stored_password, openssl_cipher_iv_length('aes-256-cbc'));
    $password_desencriptada = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);

    // Llenar los datos en el Excel
    $sheet->setCellValue("A{$row}", $usuario['correo']);
    $sheet->setCellValue("B{$row}", $usuario['nombre']);
    $sheet->setCellValue("C{$row}", $password_desencriptada); // Contraseña desencriptada
    $row++;
}

// Guardar el archivo Excel en la carpeta 'excel'
$filePath = __DIR__ . '/usuarios.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filePath);

// Enviar el archivo por correo
$mail = new PHPMailer(true);

try {
    // Configuración del servidor de correo
    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];
    $mail->Port = $_ENV['SMTP_PORT'];

    // Configuración del correo
    $mail->setFrom($_ENV['SMTP_USERNAME'], 'System');
    $mail->addAddress('larry.g@hostdime.co'); // Dirección de destino

    // Adjuntar archivo Excel
    $mail->addAttachment($filePath);

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Asesores registrados para ANDICOM 2024';
    $mail->Body = 'Hola Hilda, espero que estés bien. Aquí te envío el documento Excel con la información de cada asesor que están registrados para la ANDICOM.';

    // Enviar correo
    $mail->send();
    echo 'Correo enviado con éxito';

    // Eliminar el archivo después de enviar el correo
    if (file_exists($filePath)) {
        unlink($filePath);
    }

} catch (Exception $e) {
    echo "El correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
}
?>
