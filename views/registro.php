<?php
  include("../conexion/conexion.php");

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
    <link rel="stylesheet" href="../css/registro.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-form">
                <img class="logo" src="../img/logo.png" alt="Logo">
                <form action="../php/login_register/registro.php" method="post">
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