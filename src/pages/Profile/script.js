document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('change-password-modal');
    const changePasswordLink = document.querySelector('.change-password');
    const closeButton = document.querySelector('.close-button');
    const saveButton = document.getElementById('save-password-button');
    const cancelButton = document.getElementById('cancel-password-button');

    changePasswordLink.addEventListener('click', (event) => {
        event.preventDefault();
        modal.style.display = 'flex';
    });

    closeButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    cancelButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    saveButton.addEventListener('click', () => {
        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (newPassword === confirmPassword) {
            alert('Password berhasil diubah!');
            modal.style.display = 'none';
        } else {
            alert('Kata sandi baru tidak cocok!');
        }
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});