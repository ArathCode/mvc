document.addEventListener("DOMContentLoaded", function () {
    const tipoUsuario = localStorage.getItem("tipo_usuario"); 

    if (tipoUsuario !== "admin") {
        document.querySelectorAll(".admin-only").forEach(el => el.remove());
    }
});