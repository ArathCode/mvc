import { validaLargo, validaRango } from "./validaciones.js?v=3.7";

document.addEventListener("DOMContentLoaded", () => {
    let filtros = document.querySelectorAll(".filter");
    let filtroFechas = document.querySelector(".filter-fechas");
    let fechaInicio = document.getElementById("fechaInicio");
    let fechaFin = document.getElementById("fechaFin");
    let btnFiltrar = document.getElementById("btnFiltrar");

    let añoSelect = document.getElementById("año");
    let añoActual = new Date().getFullYear();
    for (let i = 0; i < 10; i++) {
        let opcion = document.createElement("option");
        opcion.textContent = añoActual - i;
        añoSelect.appendChild(opcion);
    }

    listarGastos(); 

    // Manejo de selección de filtros
    filtros.forEach(filtro => {
        filtro.addEventListener("click", function () {
            filtros.forEach(f => f.classList.remove("active")); // Desactiva otros filtros
            this.classList.add("active"); // Activa el filtro seleccionado
    
            const today = new Date();
    
            // Lógica para cada tipo de filtro
            if (this.dataset.filter === "hoy") {
                const hoy = today.toISOString().split("T")[0];
                fechaInicio.value = hoy;
                fechaFin.value = hoy;
    
                console.log("Filtro 'Hoy' seleccionado. Parámetros enviados:", hoy, hoy);
                listarGastos(); // Llama a la función con el filtro
    
            } else if (this.dataset.filter === "semana") {
                const primerDiaSemana = new Date(today.setDate(today.getDate() - today.getDay()));
                const ultimoDiaSemana = new Date(primerDiaSemana);
                ultimoDiaSemana.setDate(primerDiaSemana.getDate() + 6);
    
                fechaInicio.value = primerDiaSemana.toISOString().split("T")[0];
                fechaFin.value = ultimoDiaSemana.toISOString().split("T")[0];
    
                console.log("Filtro 'Semana' seleccionado. Parámetros enviados:", fechaInicio.value, fechaFin.value);
                listarGastos();
    
            } else if (this.dataset.filter === "mes") {
                const mesSeleccionado = document.getElementById("mes").value || (today.getMonth() + 1); // Mes actual por defecto
                const añoActual = new Date().getFullYear();
    
                const primerDiaMes = new Date(`${añoActual}-${mesSeleccionado}-01`);
                const ultimoDiaMes = new Date(primerDiaMes.getFullYear(), primerDiaMes.getMonth() + 1, 0);
    
                fechaInicio.value = primerDiaMes.toISOString().split("T")[0];
                fechaFin.value = ultimoDiaMes.toISOString().split("T")[0];
    
                console.log("Filtro 'Mes' seleccionado. Parámetros enviados:", fechaInicio.value, fechaFin.value);
                listarGastos();
    
            } else if (this.dataset.filter === "año") {
                const añoSeleccionado = document.getElementById("año").value || new Date().getFullYear();
    
                fechaInicio.value = `${añoSeleccionado}-01-01`;
                fechaFin.value = `${añoSeleccionado}-12-31`;
    
                console.log("Filtro 'Año' seleccionado. Parámetros enviados:", fechaInicio.value, fechaFin.value);
                listarGastos();
    
            } else if (this.dataset.filter === "dia") {
                const inputFecha = document.getElementById("fecha");
                const hoy = new Date().toISOString().split("T")[0];
    
                // Aseguramos que el input esté visible y tenga un valor predefinido
                inputFecha.classList.remove("hidden");
                if (!inputFecha.value) {
                    inputFecha.value = hoy; 
                }
    
                inputFecha.addEventListener("change", function () {
                    const diaSeleccionado = inputFecha.value;
    
                    if (diaSeleccionado) {
                        fechaInicio.value = diaSeleccionado;
                        fechaFin.value = diaSeleccionado;
    
                        console.log("Filtro 'Día' seleccionado. Parámetros enviados:", diaSeleccionado);
                        listarGastos();
                    } else {
                        alert("Por favor, selecciona un día válido.");
                    }
                });
    
                console.log("Filtro 'Día' activado. Día actual predefinido:", hoy);
            }
        });
    });
    
    
    const limpiarGastos = document.getElementById("limpiarG");

    limpiarGastos.addEventListener("click", function () {
        filtros.forEach(filtro => filtro.classList.remove("active"));

        document.getElementById("fechaInicio").value = "";
        document.getElementById("fechaFin").value = "";
        document.getElementById("fecha").value = "";
        document.getElementById("mes").value = "";
        document.getElementById("año").value = "";

        console.log("Filtros limpiados. Mostrando todos los gastos.");
        listarGastos(); 
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
    
        listarGastos(); 
    });
    

    // Agregar gasto
    const formGasto = document.querySelector("#formAgregarGasto");
    if (formGasto) {
        formGasto.addEventListener("submit", (event) => {
            event.preventDefault();
            let errores = 0;

            let descripcion = document.querySelector("#Descripcion");
            let precio = document.querySelector("#Precio");

            agregarGasto();
        });
    }

    // Editar y eliminar
    const listaGastos = document.querySelector("#ListaGastos");
    if (listaGastos) {
        listaGastos.addEventListener("click", (event) => {
            event.preventDefault();
            const target = event.target;

            if (target.classList.contains("btn-editar")) {
                cargarGasto(target.dataset.id);
            } else if (target.classList.contains("btn-eliminar")) {
                eliminarGasto(target.dataset.id);
            }
        });
    }

    const formEditarGasto = document.querySelector("#formEditarGasto");
    if (formEditarGasto) {
        formEditarGasto.addEventListener("submit", (event) => {
            event.preventDefault();
            let erroresE = 0;
            let descripcionE = document.querySelector("#DescripcionEdit");
            let precioE = document.querySelector("#PrecioEdit");

            editarGasto();
        });
    }
});

// Función para listar gastos
let paginaActual = 1;
const registrosPorPagina = 10;


// Función para listar los gastos (incluyendo filtros)
export function listarGastos() {
    console.log("listarGastos llamada");
    
    const fechaInicio = document.getElementById("fechaInicio").value || "0000-01-01";
    const fechaFin = document.getElementById("fechaFin").value || "2100-12-31";

    let params = new URLSearchParams();
    params.append("ope", "LISTARGASTOS");
    params.append("pagina", paginaActual);
    params.append("registrosPorPagina", registrosPorPagina);

    if (fechaInicio !== "0000-01-01" || fechaFin !== "2100-12-31") {
        params.append("fechaInicio", fechaInicio);
        params.append("fechaFin", fechaFin);
    }

    console.log("Parámetros enviados:", params.toString());

    fetch('../controlador/controladorGasto.php', {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString()
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log("Respuesta recibida:", data);
        if (!data.success) {
            console.error("Error al cargar gastos:", data.error);
            return;
        }
        renderizarGastos(data.lista);
        actualizarPaginacion(data.totalPaginas);
    })
    .catch(error => {
        console.error("Error en la carga de gastos:", error);
    });
}



function renderizarGastos(lista) {
    const contenedor = document.querySelector("#ListaGastos");
    contenedor.innerHTML = "";

    if (!lista || lista.length === 0) {
        contenedor.innerHTML = "<p>No hay gastos en este rango de fechas.</p>";
        return;
    }

    lista.forEach(gasto => {
        contenedor.innerHTML += `
            <div class="gasto-card">
                <h3>${gasto.Descripcion}</h3>
                <p><strong>Monto:</strong> $${gasto.Precio}</p>
                <p><strong>Fecha:</strong> ${gasto.Fecha}</p>
                <p><strong>Registrado por:</strong> ${gasto.Nombre}</p>
                <div class="card-buttons">
                    <button class="btn btn-warning btn-editar" data-id="${gasto.ID_Gasto}" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                    <button class="btn btn-danger btn-eliminar" data-id="${gasto.ID_Gasto}">Eliminar</button>
                </div>
            </div>
        `;
    });
}


// Función para actualizar la paginación
function actualizarPaginacion(totalPaginas) {
    const paginacion = document.querySelector("#paginacion");

    if (!paginacion) {
        console.error("Error: No se encontró el contenedor #paginacion.");
        return;
    }

    paginacion.innerHTML = ""; 

    for (let i = 1; i <= totalPaginas; i++) {
        let boton = document.createElement("button");
        boton.classList.add("btn", i === paginaActual ? "btn-primary" : "btn-outline-primary");
        boton.textContent = i;
        boton.addEventListener("click", () => cambiarPagina(i));

        paginacion.appendChild(boton);
    }
}

// Función para cambiar de página
function cambiarPagina(nuevaPagina) {
    paginaActual = nuevaPagina;
    listarGastos(); 
}

// Funciones para agregar, editar y eliminar gastos
function agregarGasto() {
    const form = document.querySelector("#formAgregarGasto");
    const datos = new FormData(form);
    datos.append("ope", "AGREGAR");

    fetch('../controlador/controladorGasto.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Gasto agregado correctamente", "success");
            form.reset();
            document.querySelector("#modalAgregar .btn-close").click();
            listarGastos();
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo agregar el gasto: " + error.message, "error");
    });
}

function cargarGasto(id) {
    fetch('../controlador/controladorGasto.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "OBTENER", "ID_Gasto": id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector("#ID_Gasto").value = data.gasto.ID_Gasto;
            document.querySelector("#DescripcionEdit").value = data.gasto.Descripcion;
            document.querySelector("#PrecioEdit").value = data.gasto.Precio;
            document.querySelector("#FechaEdit").value = data.gasto.Precio;
        } else {
            Swal.fire("Error", "No se pudo obtener la información del gasto", "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo obtener la información del gasto: " + error.message, "error");
    });
}

function editarGasto() {
    const form = document.querySelector("#formEditarGasto");
    const datos = new FormData(form);
    datos.append("ope", "EDITAR");

    fetch('../controlador/controladorGasto.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Gasto actualizado correctamente", "success");
            document.querySelector("#modalEditar .btn-close").click();
            listarGastos();
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo actualizar el gasto: " + error.message, "error");
    });
}

function eliminarGasto(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción no se puede deshacer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../controlador/controladorGasto.php', {
                method: 'POST',
                body: new URLSearchParams({ "ope": "ELIMINAR", "ID_Gasto": id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Eliminado", "Gasto eliminado correctamente", "success");
                    listarGastos();
                } else {
                    Swal.fire("Error", data.msg, "error");
                }
            })
            .catch(error => {
                Swal.fire("Error", "No se pudo eliminar el gasto: " + error.message, "error");
            });
        }
    });

    
}
