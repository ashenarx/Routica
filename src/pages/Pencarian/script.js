document.addEventListener('DOMContentLoaded', () => {
    const isLoggedIn = localStorage.getItem("isLoggedIn");
    if (!isLoggedIn) {
        alert("Silakan login terlebih dahulu.");
        window.location.href = "../Login/login.html";
    }
});
