document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const icon = document.getElementById('toggle-password-icon');

    togglePassword.addEventListener('click', function () {
        const isPasswordVisible = passwordInput.type === 'text';
        passwordInput.type = isPasswordVisible ? 'password' : 'text';
        icon.classList.toggle('fa-eye-slash');
        icon.classList.toggle('fa-eye');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // First password field toggle
    const togglePassword1 = document.getElementById('toggle-password-1');
    const passwordInput1 = document.getElementById('password');
    const icon1 = document.getElementById('toggle-password-icon-1');

    togglePassword1.addEventListener('click', function () {
        const isPasswordVisible = passwordInput1.type === 'text';
        passwordInput1.type = isPasswordVisible ? 'password' : 'text';
        icon1.classList.toggle('fa-eye-slash');
        icon1.classList.toggle('fa-eye');
    });

    // Second password confirmation field toggle
    const togglePassword2 = document.getElementById('toggle-password-2');
    const passwordInput2 = document.getElementById('password-confirmation');
    const icon2 = document.getElementById('toggle-password-icon-2');

    togglePassword2.addEventListener('click', function () {
        const isPasswordVisible = passwordInput2.type === 'text';
        passwordInput2.type = isPasswordVisible ? 'password' : 'text';
        icon2.classList.toggle('fa-eye-slash');
        icon2.classList.toggle('fa-eye');
    });
});