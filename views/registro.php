<?php
session_start();

if (!isset($_SESSION['correo'])) {
  echo '
    <script>
        alert("Por favor inicie sesión e intente nuevamente");
        window.location = "../index.php";
    </script>
    ';
  session_destroy();
  die();
}
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
   <style>
    
    .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px; /* Espacio para el ícono del ojo */
            box-sizing: border-box; /* Asegura que el padding se considere en el ancho total del input */
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 40%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2em;
            color: #666;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
   </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-form">
                <img class="logo" src="../img/logo.png" alt="Logo">
                <form id="registroForm" action="../php/login_register/registro.php" method="post" onsubmit="return validarFormulario()">
                    <label for="correo">Correo:</label>
                    <input type="email" id="correo" name="correo" placeholder="Correo" required>
                    <div id="correoError" class="error-message"></div>

                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                    <div id="nombreError" class="error-message"></div>

                    <label for="password">Contraseña:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Contraseña" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
                    </div>
                    <div id="passwordError" class="error-message"></div>

                    <label for="id_rol">Rol:</label>
                    <select id="id_rol" name="id_rol" required>
                        <option value="" disabled selected>Elige el rol del usuario</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?php echo $rol['id']; ?>"><?php echo $rol['roll']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="rolError" class="error-message"></div>

                    <button type="submit">Registrarse</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/registro.js">
      
    </script>
</body>

</html>
