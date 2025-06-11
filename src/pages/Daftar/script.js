function showDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.style.display = 'flex';
    modal.classList.add('active');
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.style.display = 'none';
    modal.classList.remove('active');
}