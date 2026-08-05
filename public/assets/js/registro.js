document.addEventListener("DOMContentLoaded", () => {
    const formulario = document.querySelector(".formulario-registro");
    const telefono = document.getElementById("telefono");

    formulario.addEventListener("submit", function (event) {
        const pass = document.getElementById("password").value;
        const passConfirm = document.getElementById("password_confirm").value;
        const errorDiv = document.getElementById("password-error");

        if (pass !== passConfirm) {
            event.preventDefault();
            errorDiv.style.display = "block";
        } else {
            errorDiv.style.display = "none";
        }
    });

    telefono.addEventListener("input", () => {
        telefono.value = telefono.value.replace(/[^0-9-]/g, "");
    });
});
