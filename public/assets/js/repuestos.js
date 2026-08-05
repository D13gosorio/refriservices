document.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById("ordenar");
    const grid = document.querySelector(".grid-repuestos");

    select.addEventListener("change", () => {
        const opcion = select.value;

        const tarjetas = Array.from(document.querySelectorAll(".card-repuesto"));

        tarjetas.sort((a, b) => {
            const nombreA = a.querySelector("h3").innerText.trim();
            const nombreB = b.querySelector("h3").innerText.trim();

            const precioA = parseFloat(a.querySelector(".precio").innerText.replace("$", ""));
            const precioB = parseFloat(b.querySelector(".precio").innerText.replace("$", ""));

            const stockA = parseInt(a.querySelector(".stock").innerText.replace("Stock: ", "").replace(" unidades", ""));
            const stockB = parseInt(b.querySelector(".stock").innerText.replace("Stock: ", "").replace(" unidades", ""));

            switch (opcion) {
                case "nombre_asc":  return nombreA.localeCompare(nombreB);
                case "nombre_desc": return nombreB.localeCompare(nombreA);
                case "precio_asc":  return precioA - precioB;
                case "precio_desc": return precioB - precioA;
                case "stock_asc":   return stockA - stockB;
                case "stock_desc":  return stockB - stockA;
            }
        });

        tarjetas.forEach(t => grid.appendChild(t));
    });
});
