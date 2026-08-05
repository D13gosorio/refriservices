// Confirmación antes de enviar formularios marcados con data-confirm="mensaje".
// Reemplaza los antiguos atributos onsubmit="return confirm(...)" inline,
// que una Content-Security-Policy estricta (sin 'unsafe-inline') bloquea.
document.addEventListener("submit", function (event) {
    const form = event.target;

    if (form instanceof HTMLFormElement && form.hasAttribute("data-confirm")) {
        const mensaje = form.getAttribute("data-confirm");

        if (!window.confirm(mensaje)) {
            event.preventDefault();
        }
    }
});
