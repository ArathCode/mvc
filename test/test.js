document.addEventListener("DOMContentLoaded", function () {
    let filtros = document.querySelectorAll(".filter");
    let filtroFechas = document.querySelector(".filter-fechas");
    let fechaInicio = document.getElementById("fechaInicio");
    let fechaFin = document.getElementById("fechaFin");
    let btnFiltrar = document.getElementById("btnFiltrar");

    // Generar años en el select (últimos 10 años)
    let añoSelect = document.getElementById("año");
    let añoActual = new Date().getFullYear();
    for (let i = 0; i < 10; i++) {
        let opcion = document.createElement("option");
        opcion.textContent = añoActual - i;
        añoSelect.appendChild(opcion);
    }

    // Manejo de selección de filtros
    filtros.forEach(filtro => {
        filtro.addEventListener("click", function (event) {
            // Si se hace clic en la "X", desactivar el filtro
            if (event.target.classList.contains("close")) {
                this.classList.remove("active");
                
                // Ocultar los inputs y el botón en el filtro de rango de fechas
                if (this === filtroFechas) {
                    fechaInicio.classList.add("hidden");
                    fechaFin.classList.add("hidden");
                    btnFiltrar.classList.add("hidden");
                }
                return;
            }

            // Desactivar todos los filtros antes de activar el actual
            filtros.forEach(f => f.classList.remove("active"));
            this.classList.add("active");

            // Si el filtro es "Rango de Fechas", mostrar los inputs y el botón
            if (this === filtroFechas) {
                fechaInicio.classList.remove("hidden");
                fechaFin.classList.remove("hidden");
                btnFiltrar.classList.remove("hidden");
            }
        });
    });

    btnFiltrar.addEventListener("click", function () {
        let inicio = fechaInicio.value;
        let fin = fechaFin.value;

        if (!inicio || !fin) {
            alert("Por favor, seleccione ambas fechas.");
            return;
        }

        if (inicio > fin) {
            alert("La fecha de inicio no puede ser mayor que la fecha de fin.");
            return;
        }

        alert(`Filtrando desde: ${inicio} hasta ${fin}`);
    });
});
