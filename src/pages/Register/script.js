const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const registerButton = document.getElementById('register-button');

function updateButtonState() {
    const isFilled = emailInput.value.trim() && passwordInput.value.trim();
    registerButton.classList.toggle('active', isFilled);
}

emailInput.addEventListener('input', updateButtonState);
passwordInput.addEventListener('input', updateButtonState);

registerButton.addEventListener('click', async () => {
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    if (!email || !password) {
        alert('Harap isi kedua kolom.');
        return;
    }

    try {
        const response = await fetch('http://localhost/Routica/service/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`,
        });

        const result = await response.json();

        if (response.ok) {
            alert(result.message);
            window.location.href = '../Login/login.html';
        } else {
            alert(result.message);
        }
    } catch (error) {
        alert('Terjadi kesalahan saat registrasi.');
        console.error(error);
    }
});