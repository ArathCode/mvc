import { validaLargo, validaRango } from "./validaciones.js?v=3.7";
document.addEventListener("DOMContentLoaded", () => {
    listarGastos();

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
function listarGastos() {
    fetch('../controlador/controladorGasto.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "LISTARGASTOS" })
    })
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector("#ListaGastos tbody");
        tbody.innerHTML = "";
        data.lista.forEach(gasto => {
            tbody.innerHTML += `
            <tr>
                <td>${gasto.ID_Gasto}</td>
                <td>${gasto.Descripcion}</td>
                <td>${gasto.Precio}</td>
                <td>${gasto.Fecha}</td>
                <td>${gasto.Nombre}</td> <!-- Cambiado de ID_Usuario a Nombre -->
                <td>
                    <button class="btn btn-warning btn-editar" data-id="${gasto.ID_Gasto}" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                    <button class="btn btn-danger btn-eliminar" data-id="${gasto.ID_Gasto}">Eliminar</button>
                </td>
            </tr>
            `;
        });
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo cargar la lista de gastos: " + error.message, "error");
    });
}

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
