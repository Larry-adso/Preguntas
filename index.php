<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HostDime</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="img">
                <img src="img/login.png" alt="Background Image" class="background-image">
            </div>
            <div class="login-form">
                <img class="logo" src="img/logo.png" alt="Logo">
                <form action="php/login_register/login.php" method="post" >
                    <label for="email">Correo:</label>
                    <input type="email" id="email" name="correo" placeholder="Correo" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
