<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HostDime</title>
    <link rel="stylesheet" href="css/index.css">
    <style>
        .password-container {
            position: relative;
            width: 100%;
            max-width: 100%;
        }

        .password-container input[type="password"],
        .password-container input[type="text"] {
            width: 100%;
            padding-right: 40px; /* espacio para el ícono */
            box-sizing: border-box; /* incluye padding y borde dentro del ancho */
            height: 36px; /* Asegura que el input mantenga su altura */
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 40%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px; /* Ajusta el tamaño del ícono */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="img">
                <img src="img/login.png" alt="Background Image" class="background-image">
            </div>
            <div class="login-form">
                <img class="logo" src="img/logo.png" alt="Logo">
                <form action="php/login_register/login.php" method="post">
                    <label for="email">Correo:</label>
                    <input type="email" id="email" name="correo" placeholder="Correo" required>
                    
                    <label for="password">Contraseña:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Contraseña" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                        🙈
                        </span>
                    </div>
                    <br>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div> 

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.textContent = '🙉';
            } else {
                passwordInput.type = 'password';
                togglePassword.textContent = '🙈';
            }
        }
    </script>
</body>
</html>
