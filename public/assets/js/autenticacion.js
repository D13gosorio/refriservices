// Mejoras de las pantallas de acceso y registro.
//
// Todo lo que hay aquí es ayuda para quien rellena el formulario. Ninguna
// comprobación de estas sustituye a la del servidor: el navegador es del
// visitante y cualquiera puede saltarse este archivo.

document.addEventListener("DOMContentLoaded", () => {

    /* ------------------------------------------------------------------
       Mostrar u ocultar la contraseña
    ------------------------------------------------------------------ */
    // El botón se crea desde aquí y no en el HTML a propósito: sin
    // JavaScript sería un botón que no hace nada al pulsarlo.
    document.querySelectorAll(".campo-password").forEach((campo) => {
        const entrada = campo.querySelector("input");
        if (!entrada) return;

        const boton = document.createElement("button");
        boton.type = "button";
        boton.className = "boton-ver-password";
        boton.textContent = "Mostrar";
        boton.setAttribute("aria-label", "Mostrar la contraseña");
        boton.setAttribute("aria-pressed", "false");

        boton.addEventListener("click", () => {
            const visible = entrada.type === "text";
            entrada.type = visible ? "password" : "text";
            boton.textContent = visible ? "Mostrar" : "Ocultar";
            boton.setAttribute("aria-label", visible ? "Mostrar la contraseña" : "Ocultar la contraseña");
            boton.setAttribute("aria-pressed", visible ? "false" : "true");
            entrada.focus();
        });

        campo.appendChild(boton);
    });

    /* ------------------------------------------------------------------
       Teléfono: formato 0000-0000
    ------------------------------------------------------------------ */
    const telefono = document.getElementById("telefono");

    if (telefono) {
        telefono.addEventListener("input", () => {
            const digitos = telefono.value.replace(/\D/g, "").slice(0, 8);

            // El guion se pone solo. Antes se dejaba escribirlo a mano en
            // cualquier posición, y el formulario lo rechazaba al enviar.
            telefono.value = digitos.length > 4
                ? digitos.slice(0, 4) + "-" + digitos.slice(4)
                : digitos;
        });
    }

    /* ------------------------------------------------------------------
       Requisitos de la contraseña, marcados mientras se escribe
    ------------------------------------------------------------------ */
    const password = document.getElementById("password");
    const confirmar = document.getElementById("password_confirm");
    const listaRequisitos = document.getElementById("requisitos-password");

    // Las mismas reglas que aplica AuthController::doRegistro().
    const reglas = {
        longitud: (v) => v.length >= 8,
        letra: (v) => /[A-Za-z]/.test(v),
        numero: (v) => /\d/.test(v),
    };

    const revisarRequisitos = () => {
        if (!listaRequisitos || !password) return;

        listaRequisitos.querySelectorAll("li[data-regla]").forEach((item) => {
            const cumple = reglas[item.dataset.regla](password.value);
            item.classList.toggle("cumplido", cumple);

            // La marca visual es un pseudoelemento, que un lector de pantalla
            // no anuncia; este texto oculto es el que comunica el estado.
            let estado = item.querySelector(".estado-regla");
            if (!estado) {
                estado = document.createElement("span");
                estado.className = "estado-regla visualmente-oculto";
                item.appendChild(estado);
            }
            estado.textContent = cumple ? " (cumplido)" : " (pendiente)";
        });
    };

    // Aviso en cuanto se despega del campo, no al enviar: así no se descubre
    // el fallo después de haber rellenado todo lo demás.
    const revisarCoincidencia = () => {
        if (!password || !confirmar) return;

        const coinciden = confirmar.value === "" || password.value === confirmar.value;
        confirmar.setCustomValidity(coinciden ? "" : "Las contraseñas no coinciden.");
        confirmar.classList.toggle("campo-invalido", !coinciden);

        const aviso = document.getElementById("mensaje-password-confirm");
        if (aviso) {
            aviso.textContent = coinciden ? "" : "Las contraseñas no coinciden.";
        }
    };

    if (password) {
        password.addEventListener("input", () => {
            revisarRequisitos();
            revisarCoincidencia();
        });
        revisarRequisitos();
    }

    if (confirmar) {
        confirmar.addEventListener("input", revisarCoincidencia);
        confirmar.addEventListener("blur", revisarCoincidencia);
    }

    /* ------------------------------------------------------------------
       Evitar envíos duplicados
    ------------------------------------------------------------------ */
    // Un doble clic en una conexión lenta llegaba a mandar el formulario dos
    // veces, y en el registro eso son dos intentos gastados del límite por
    // hora. El botón solo se bloquea si el navegador da el formulario por
    // válido; si no, seguiría deshabilitado tras un error de validación.
    document.querySelectorAll("form.formulario-auth").forEach((formulario) => {
        formulario.addEventListener("submit", () => {
            if (!formulario.checkValidity()) return;

            const boton = formulario.querySelector("button[type=submit]");
            if (!boton) return;

            boton.disabled = true;
            boton.textContent = "Enviando…";
        });
    });
});
