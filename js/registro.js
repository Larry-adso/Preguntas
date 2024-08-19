function validarFormulario() {
    let esValido = true;

    // Validar correo
    const correo = document.getElementById('correo').value;
    const correoError = document.getElementById('correoError');
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!correoRegex.test(correo)) {
        correoError.textContent = 'Por favor ingresa un correo válido.';
        esValido = false;
    } else {
        correoError.textContent = '';
    }

    // Validar nombre
    const nombre = document.getElementById('nombre').value;
    const nombreError = document.getElementById('nombreError');
    if (nombre.trim() === '') {
        nombreError.textContent = 'El nombre no puede estar vacío.';
        esValido = false;
    } else {
        nombreError.textContent = '';
    }

    // Validar contraseña
    const password = document.getElementById('password').value;
    const passwordError = document.getElementById('passwordError');
    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!passwordRegex.test(password)) {
        passwordError.textContent = 'La contraseña debe ser alfanumérica y tener al menos 8 caracteres.';
        esValido = false;
    } else {
        passwordError.textContent = '';
    }

    // Validar selección de rol
    const id_rol = document.getElementById('id_rol').value;
    const rolError = document.getElementById('rolError');
    if (id_rol === '') {
        rolError.textContent = 'Por favor selecciona un rol.';
        esValido = false;
    } else {
        rolError.textContent = '';
    }

    return esValido;
}

function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.querySelector('.toggle-password');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.textContent = '🙈'; // Cambia el icono
    } else {
        passwordField.type = 'password';
        toggleIcon.textContent = '👁️'; // Cambia el icono
    }
}