document.addEventListener('DOMContentLoaded', () => {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const loginButton = document.getElementById('login-button');
    function updateButtonState() {
        const isFilled = emailInput.value.trim() && passwordInput.value.trim();
        loginButton.classList.toggle('active', isFilled);
    }

    emailInput.addEventListener('input', updateButtonState);
    passwordInput.addEventListener('input', updateButtonState);
    loginButton.addEventListener('click', () => {
        if (emailInput.value.trim() && passwordInput.value.trim()) {
            // Simulate a login action
            alert('Login successful!');
            window.location.href = "../Pencarian/pencarian.html";
        } else {
            alert('Please fill in both fields.');
        }
    });
});