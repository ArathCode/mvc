import { validaCorreo, validaLargo, validaRango, validaSoloLetras, validaContrasena } from "./validaciones.js?v=3.7";
document.addEventListener("DOMContentLoaded", () => {
    listarMembresias();

    // agregar membresía
    const formMembresia = document.querySelector("#formAgregar");
    if (formMembresia) {
        formMembresia.addEventListener("submit", (event) => {
            event.preventDefault();
            agregarMembresia();
        });
    }

    //  editar y eliminar membresía
    const listaMembresias = document.querySelector("#ListaMembresias");
    if (listaMembresias) {
        listaMembresias.addEventListener("click", (event) => {
            event.preventDefault();
            const target = event.target;

            if (target.classList.contains("btn-editar")) {
                cargarMembresia(target.dataset.id);
            } else if (target.classList.contains("btn-eliminar")) {
                eliminarMembresia(target.dataset.id);
            }
        });
    }

    const formEditarMembresia = document.querySelector("#formEditar");
    if (formEditarMembresia) {
        formEditarMembresia.addEventListener("submit", (event) => {
            event.preventDefault();
            editarMembresia();
        });
    }
});

// Función para listar membresías
function listarMembresias() {
    fetch('controlador/controladorMembresias.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "LISTAMEMBRESIAS" })
    })
    .then(response => response.json())
    .then(data => {
        const contenedor = document.querySelector("#ListaMembresias");
        contenedor.innerHTML = ""; // Limpiamos el contenedor antes de agregar las nuevas tarjetas

        data.lista.forEach(membresia => {
            contenedor.innerHTML += `
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">${membresia.Tipo}</h5>
                            <p class="card-text">Descripción: ${membresia.Descripcion}</p>
                            <p class="card-text">Costo: $${membresia.Costo}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning btn-editar" data-id="${membresia.ID_Membresia}" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                                    <button class="btn btn-sm btn-danger btn-eliminar" data-id="${membresia.ID_Membresia}">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo cargar la lista de membresías: " + error.message, "error");
    });
}


function agregarMembresia() {
    const form = document.querySelector("#formAgregar");
    const datos = new FormData(form);
    datos.append("ope", "AGREGAR");

    fetch('controlador/controladorMembresias.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Membresía agregada correctamente", "success");
            form.reset();
            document.querySelector("#modalAgregar .btn-close").click();
            listarMembresias();
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo agregar la membresía: " + error.message, "error");
    });
}

function cargarMembresia(id) {
    fetch('controlador/controladorMembresias.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "OBTENER", "ID_Membresia": id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector("#ID_Membresia").value = data.membresia.ID_Membresia;
            document.querySelector("#TipoEdit").value = data.membresia.Tipo;
            document.querySelector("#DescripcionEdit").value = data.membresia.Descripcion;
            document.querySelector("#CostoEdit").value = data.membresia.Costo;
        } else {
            Swal.fire("Error", "No se pudo obtener la información de la membresía", "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo obtener la información de la membresía: " + error.message, "error");
    });
}

function editarMembresia() {
    const form = document.querySelector("#formEditar");
    const datos = new FormData(form);
    datos.append("ope", "EDITAR");

    fetch('controlador/controladorMembresias.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Membresía actualizada correctamente", "success");
            document.querySelector("#modalEditar .btn-close").click();
            listarMembresias();
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo actualizar la membresía: " + error.message, "error");
    });
}

function eliminarMembresia(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción no se puede deshacer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('controlador/controladorMembresias.php', {
                method: 'POST',
                body: new URLSearchParams({ "ope": "ELIMINAR", "ID_Membresia": id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Eliminado", "Membresía eliminada correctamente", "success");
                    listarMembresias();
                } else {
                    Swal.fire("Error", data.msg, "error");
                }
            })
            .catch(error => {
                Swal.fire("Error", "No se pudo eliminar la membresía: " + error.message, "error");
            });
        }
    });
}
