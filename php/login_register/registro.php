<?php
include("../../conexion/conexion.php");
include("../../includes/alertas.php");

// Iniciar sesión
session_start();

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar la entrada
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = hash('sha512', $password);
    $id_rol = filter_var($_POST['id_rol'], FILTER_VALIDATE_INT);

    // Preparar y ejecutar la consulta para insertar un nuevo usuario
    $stmt = $conexion->prepare("INSERT INTO usuarios (correo, password, nombre, id_rol) VALUES (:correo, :password, :nombre, :id_rol)");
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':id_rol', $id_rol);

    if ($stmt->execute()) {
        echo "Registro exitoso. Ahora puedes <a href='login.php'>iniciar sesión</a>.";
    } else {
        echo "Error al registrar el usuario.";
    }
}

// Obtener los roles disponibles
$stmt = $conexion->prepare("SELECT id, roll FROM roles");
$stmt->execute();
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - HostDime</title>
    <link rel="stylesheet" href="../../css/registro.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-form">
                <img class="logo" src="../../img/logo.png" alt="Logo">
                <form action="#" method="post">
                    <label for="correo">Correo:</label>
                    <input type="email" id="correo" name="correo" placeholder="Correo" required>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                    <label for="id_rol">Rol:</label>
                    <select id="id_rol" name="id_rol" required>
                        <option value="" disabled selected>Elige el rol del usuario</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?php echo $rol['id']; ?>"><?php echo $rol['roll']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>