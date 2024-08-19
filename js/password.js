const togglePassword = document.querySelector('#toggle-password');
const passwordField = document.querySelector('#password');

togglePassword.addEventListener('click', function () {
    // Toggle the type attribute
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);

    // Toggle the eye icon
    this.textContent = type === 'password' ? '🙉' : '🙈';
});
