import { validaLargo, validaRango } from "./validaciones.js?v=3.7";
document.addEventListener("DOMContentLoaded", () => {
    
    
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

// Función para listar gastos
export function listarGastos() {
    const fechaInicio = document.getElementById("fechaInicio").value;
    const fechaFin = document.getElementById("fechaFin").value;

    let params = new URLSearchParams();
    params.append("ope", "LISTARGASTOS");
    params.append("pagina", paginaActual);
    params.append("registrosPorPagina", registrosPorPagina);

    if (fechaInicio) params.append("fechaInicio", fechaInicio);
    if (fechaFin) params.append("fechaFin", fechaFin);

    fetch('../controlador/controladorGasto.php', {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString()
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json(); // Convertir la respuesta a JSON
    })
    .then(data => {
        const contenedor = document.querySelector("#ListaGastos");
        contenedor.innerHTML = "";

        if (!data.success) {
            throw new Error(data.error || "Error desconocido");
        }

        if (!data.lista || data.lista.length === 0) {
            contenedor.innerHTML = "<p>No hay gastos en este rango de fechas.</p>";
            return;
        }

        // Insertar los gastos en la página
        data.lista.forEach(gasto => {
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

        // Actualizar la paginación
        actualizarPaginacion(data.totalPaginas);
    })
    .catch(error => {
        console.error("Error en la carga de gastos:", error);
        Swal.fire("Error", "No se pudo cargar la lista de gastos: " + error.message, "error");
    });
}

// Función para actualizar la paginación
function actualizarPaginacion(totalPaginas) {
    const paginacion = document.querySelector("#paginacion");

    if (!paginacion) {
        console.error("Error: No se encontró el contenedor #paginacion.");
        return;
    }

    paginacion.innerHTML = ""; // Limpiar paginación previa

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
    listarGastos(); // Llamar la función para actualizar los datos
}

// Evento para filtrar por fecha
document.getElementById("btnListar").addEventListener("click", () => {
    paginaActual = 1; // Reiniciar a la primera página cuando se filtren los datos
    listarGastos();
});

// Cargar gastos al iniciar la página
listarGastos();

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
