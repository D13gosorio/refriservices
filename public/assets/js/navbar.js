// Menú de navegación en móvil: despliega y repliega la lista de enlaces.
// El mismo archivo sirve para la barra pública y para la del panel de
// administración, porque ambas usan las clases .hamburguesa y .menu.

const hamburguesa = document.querySelector('.hamburguesa');
const menu = document.querySelector('.menu');

// Sin esta comprobación, una página que no cargue la barra rompería el script
// entero y con él cualquier otro JS que fuera detrás.
if (hamburguesa && menu) {

    const alternar = (abrir) => {
        menu.classList.toggle('activo', abrir);
        hamburguesa.classList.toggle('activo', abrir);

        // Es lo que anuncia el estado a un lector de pantalla; si no se
        // actualiza, dice siempre que el menú está cerrado.
        hamburguesa.setAttribute('aria-expanded', abrir ? 'true' : 'false');
        hamburguesa.setAttribute('aria-label', abrir ? 'Cerrar menú de navegación' : 'Abrir menú de navegación');
    };

    hamburguesa.addEventListener('click', (evento) => {
        // Evita que el clic llegue al listener de "tocar fuera" de abajo, que
        // volvería a cerrar el menú justo después de abrirlo.
        evento.stopPropagation();
        alternar(!menu.classList.contains('activo'));
    });

    // Tocar fuera del menú lo cierra, que es lo que espera cualquiera en un
    // móvil en lugar de tener que apuntar de nuevo al botón.
    document.addEventListener('click', (evento) => {
        if (menu.classList.contains('activo') && !menu.contains(evento.target)) {
            alternar(false);
        }
    });

    document.addEventListener('keydown', (evento) => {
        if (evento.key === 'Escape' && menu.classList.contains('activo')) {
            alternar(false);
            hamburguesa.focus();
        }
    });

    // Al ensanchar la ventana el menú vuelve a mostrarse por CSS. Si no se
    // limpia el estado, la hamburguesa se queda en aspa y aria-expanded sigue
    // diciendo "abierto" cuando ya no hay nada que abrir.
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && menu.classList.contains('activo')) {
            alternar(false);
        }
    });
}
