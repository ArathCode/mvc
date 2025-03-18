import { validaCorreo, validaLargo, validaRango, validaSoloLetras, validaContrasena } from "./validaciones.js?v=3.7";
document.addEventListener("DOMContentLoaded", () => {
    listarUsuarios();
    buscarMiembroModal();
    document.querySelector(".btn-success").addEventListener("click", () => filtrarMembresias("vigentes"));
    document.querySelector(".btn-danger").addEventListener("click", () => filtrarMembresias("vencidas"));
    document.querySelector(".btn-secondary").addEventListener("click", () => filtrarMembresias("todas"));
    document.querySelector(".btn-warning").addEventListener("click", () => filtrarMembresias("proximas"));
    document.getElementById("FechaInicio").addEventListener("change", actualizarFechaFin);
    document.getElementById("Cantidad").addEventListener("input", actualizarFechaFin);
    document.getElementById("ID_Membresia").addEventListener("change", actualizarFechaFin);
    function establecerFechaActual() {
        const hoy = new Date();
        hoy.setMinutes(hoy.getMinutes() - hoy.getTimezoneOffset());

        const fechaFormateada = hoy.toISOString().split('T')[0];
        document.getElementById("FechaPago").value = fechaFormateada;
    }
    
    const formUsuario = document.querySelector("#formAgregar");
    const modal = document.getElementById("modalAgregar");
    modal.addEventListener("show.bs.modal", () => {
        establecerFechaActual();
    });
    // agregar usuario
   
    if (formUsuario) {
        formUsuario.addEventListener("submit", (event) => {
            event.preventDefault();
          

            
                agregarUsuario();
        });
    }

    //  editar y eliminar
    const listaUsuarios = document.querySelector("#ListaUsuarios");
    if (listaUsuarios) {
        listaUsuarios.addEventListener("click", (event) => {
            event.preventDefault();
            const target = event.target;

            if (target.classList.contains("btn-editar")) {
                cargarUsuario(target.dataset.id);
            } else if (target.classList.contains("btn-eliminar")) {
                eliminarUsuario(target.dataset.id);
            }
            else if (event.target.classList.contains("btn-clave")) {
                let userId = event.target.dataset.id;
                document.querySelector("#ID_UsuarioClave").value = userId;
            }
        });
        document.querySelector("#formEditarClave").addEventListener("submit", (event) => {
            event.preventDefault();
            let erroresC = 0;


            let claveC = document.querySelector("#ClaveNueva");
            let claveCC = document.querySelector("#ConfirmarClave");
            if (!validaRango(claveC, 8, 16))
                erroresC++;
            if (!validaRango(claveCC, 8, 16))
                erroresC++;
            if (!validaContrasena(claveC))
                erroresC++;
            if (!validaContrasena(claveCC))
                erroresC++;
            if (erroresC == 0)
                actualizarClave();
        });
    }


    const formEditarUsuario = document.querySelector("#formEditar");
    if (formEditarUsuario) {
        formEditarUsuario.addEventListener("submit", (event) => {
            event.preventDefault();
            let erroresE = 0;
            let nombreE = document.querySelector("#NombreEdit");
            let ApellidoPE = document.querySelector("#ApellidoPEdit");
            let ApellidoME = document.querySelector("#ApellidoMEdit");
            let correoE = document.querySelector("#CorreoUsuEdit");

            if (!validaSoloLetras(nombreE))
                erroresE++;
            if (!validaSoloLetras(ApellidoPE))
                erroresE++;
            if (!validaSoloLetras(ApellidoME))
                erroresE++;
            if (!validaCorreo(correoE))
                erroresE++;

            if (erroresE == 0)
                editarUsuario();
        });
    }


});
function actualizarFechaFin() {
    const fechaInicioInput = document.getElementById("FechaInicio");
    const cantidadInput = document.getElementById("Cantidad");
    const tipoMembresiaInput = document.getElementById("ID_Membresia"); // Lista desplegable de membresías
    const fechaFinInput = document.getElementById("FechaFin");

    // Obtener valores seleccionados
    let fechaInicio = new Date(fechaInicioInput.value);
    let cantidad = parseInt(cantidadInput.value) || 1;
    let tipoMembresia = tipoMembresiaInput.options[tipoMembresiaInput.selectedIndex].dataset.tipo;

    // Si la fecha de inicio es válida, calcular la nueva fecha fin
    if (!isNaN(fechaInicio.getTime())) {
        if (tipoMembresia === "semana") {
            fechaInicio.setDate(fechaInicio.getDate() + (7 * cantidad)); // Sumar semanas
        } else { 
            fechaInicio.setMonth(fechaInicio.getMonth() + cantidad); // Sumar meses
        }
        fechaFinInput.value = fechaInicio.toISOString().split('T')[0]; // Formato YYYY-MM-DD
    }
}
function actualizarCosto() {
    const selectMembresia = document.getElementById("ID_Membresia");
    const cantidadInput = document.getElementById("Cantidad");
    const costoInput = document.getElementById("Costo");

    const precioMembresia = selectMembresia.selectedOptions[0]?.getAttribute("data-precio") || 0;
    const cantidad = cantidadInput.value || 1;

    // Calcular costo total
    costoInput.value = (precioMembresia * cantidad).toFixed(2);
}

// Llamar a la función cuando se cambie la membresía o la cantidad
document.addEventListener('DOMContentLoaded', function () {
    cargarMembresias();
    document.getElementById("ID_Membresia").addEventListener("change", actualizarCosto);
    document.getElementById("Cantidad").addEventListener("input", actualizarCosto);
});
function buscarMiembroModal() {
    const idMiembroInput = document.querySelector("#ID_Miembro");
    const nombreMiembroInput = document.querySelector("#nombreMiembro");

    idMiembroInput.addEventListener("input", () => {
        const idMiembro = idMiembroInput.value.trim();
        if (idMiembro === "") {
            nombreMiembroInput.value = "";
            return;
        }

        fetch('controlador/controladorAcceso.php', {
            method: 'POST',
            body: new URLSearchParams({ "ope": "BUSCAR_MIEMBRO", "ID_Miembro": idMiembro })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    nombreMiembroInput.value = `${data.miembro.Nombre} ${data.miembro.ApellidoP} ${data.miembro.ApellidoM}`;
                } else {
                    nombreMiembroInput.value = "No encontrado";
                }
            })
            .catch(error => {
                console.error("Error al buscar miembro:", error);
                nombreMiembroInput.value = "Error";
            });
    });
}
// Función para listar usuarios
let paginaActual = 1;
const registrosPorPagina = 10;

let filtroActual = "vigentes";

function listarUsuarios() {
    let params = new URLSearchParams();
    params.append("ope", "LISTAUSUARIOS");
    params.append("pagina", paginaActual);
    params.append("registrosPorPagina", registrosPorPagina);
    params.append("filtro", filtroActual);

    fetch('controlador/controladorRelacionM.php', {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            Swal.fire("Error", "No se pudo cargar la lista: " + data.error, "error");
            return;
        }
        renderizarUsuarios(data.lista);
        actualizarPaginacion(data.totalPaginas);
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo cargar la lista: " + error.message, "error");
    });
}

function renderizarUsuarios(lista) {
    const tbody = document.querySelector("#ListaUsuarios tbody");
    tbody.innerHTML = "";

    if (!lista || lista.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center">No hay registros disponibles.</td></tr>`;
        return;
    }
    const hoy = new Date();
        hoy.setMinutes(hoy.getMinutes() - hoy.getTimezoneOffset());

        const fechaFormateada = hoy.toISOString().split('T')[0];
        let listaFiltrada = lista.filter(item => {
            const fechaFin = new Date(item.FechaFin);
        const diferenciaDias = Math.floor((fechaFin - hoy) / (1000 * 60 * 60 * 24));
            if (filtroActual === "vigentes") return item.FechaFin >= fechaFormateada;
            if (filtroActual === "vencidas") return item.FechaFin < fechaFormateada;
            if (filtroActual === "proximas") return diferenciaDias > -2 && diferenciaDias <= 5;
            return true; 
        });
        listaFiltrada.forEach(item => {
        const fechaFin = new Date(item.FechaFin);
        const diferenciaDias = Math.floor((fechaFin - hoy) / (1000 * 60 * 60 * 24));
        let estadoClase = "table-success"; 
        if (item.FechaFin < fechaFormateada) {
            estadoClase = "table-danger"; 
        } else if (diferenciaDias > -2 && diferenciaDias <= 5) {
            estadoClase = "table-warning"; 
        }

        
        tbody.innerHTML += `
            <tr class="${estadoClase}">
                <td>${item.ID_MiemMiembro}</td>
                <td>${item.NombreMiembro} ${item.ApellidoPMiembro} ${item.ApellidoMMiembro}</td>
                <td>${item.TipoMembresia}</td>
                <td>${item.NombreUsuario}</td>
                <td>${item.FechaInicio}</td>
                <td>${item.FechaFin}</td>
                <td>$${item.Costo}</td>
                <td>${item.Cantidad} </td>
                <td>${item.FechaPago}</td>
                <td>
                    <button class="btn btn-warning btn-editar" data-id="${item.ID_MiemMiembro}" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                    <button class="btn btn-danger btn-eliminar" data-id="${item.ID_MiemMiembro}">Eliminar</button>
                </td>
            </tr>
        `;
    });
}

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
    listarUsuarios();
}
export function filtrarMembresias(filtro) {
    filtroActual = filtro;
    listarUsuarios();
}

function agregarUsuario() {
    const form = document.querySelector("#formAgregar");
    const datos = new FormData(form);
    datos.append("ope", "AGREGAR");

    fetch('controlador/controladorRelacionM.php', {
        method: 'POST',
        body: datos
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                Swal.fire("Éxito", "Usuario agregado correctamente", "success");
                form.reset();
                document.querySelector("#modalAgregar .btn-close").click();
                listarUsuarios();

            } else {
                Swal.fire("Error", data.msg, "error");
            }
        })
        .catch(error => {
            Swal.fire("Error", "No se pudo agregar el usuario: " + error.message, "error");
        });
}


function cargarUsuario(id) {
    fetch('controlador/controladorRelacionM.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "OBTENER", "ID_Usuario": id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector("#ID_Usuario").value = data.usuario.ID_Usuario;
                document.querySelector("#NombreEdit").value = data.usuario.Nombre;
                document.querySelector("#ApellidoPEdit").value = data.usuario.ApellidoP;
                document.querySelector("#ApellidoMEdit").value = data.usuario.ApellidoM;
                document.querySelector("#CorreoUsuEdit").value = data.usuario.CorreoUsu;
                document.querySelector("#NombreUsuEdit").value = data.usuario.NombreUsu;

                document.querySelector("#SalarioEdit").value = data.usuario.Salario;
                document.querySelector("#usutipEdit").value = data.usuario.usutip;
            } else {
                Swal.fire("Error", "No se pudo obtener la información del usuario", "error");
            }
        })
        .catch(error => {
            Swal.fire("Error", "No se pudo obtener la información del usuario: " + error.message, "error");
        });
}


function editarUsuario() {
    const form = document.querySelector("#formEditar");
    const datos = new FormData(form);
    datos.append("ope", "EDITAR");

    fetch('controlador/controladorRelacionM.php', {
        method: 'POST',
        body: datos
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire("Éxito", "Usuario actualizado correctamente", "success");
                document.querySelector("#modalEditar .btn-close").click();
                listarUsuarios();
            } else {
                Swal.fire("Error", data.msg, "error");
            }
        })
        .catch(error => {
            Swal.fire("Error", "No se pudo actualizar el usuario: " + error.message, "error");
        });
}
function actualizarClave() {
    let form = document.querySelector("#formEditarClave");
    let formData = new FormData(form);

    if (formData.get("ClaveNueva") !== formData.get("ConfirmarClave")) {
        Swal.fire("Error", "Las contraseñas no coinciden", "error");
        return;
    }

    formData.append("ope", "CAMBIAR_CLAVE");

    fetch("controlador/controladorRelacionM.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire("Éxito", "Contraseña actualizada correctamente", "success");
                form.reset();
                let modal = bootstrap.Modal.getInstance(document.querySelector("#modalEditarClave"));
                modal.hide();
            } else {
                Swal.fire("Error", data.msg, "error");
            }
        })
        .catch(error => {
            Swal.fire("Error", "No se pudo actualizar la contraseña: " + error.message, "error");
        });
}


function eliminarUsuario(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción no se puede deshacer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('controlador/controladorRelacionM.php', {
                method: 'POST',
                body: new URLSearchParams({ "ope": "ELIMINAR", "ID_Usuario": id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Eliminado", "Usuario eliminado correctamente", "success");
                        listarUsuarios();
                    } else {
                        Swal.fire("Error", data.msg, "error");
                    }
                })
                .catch(error => {
                    Swal.fire("Error", "No se pudo eliminar el usuario: " + error.message, "error");
                });
        }
    });
}
// Función para cargar las membresías en el formulario
// Cargar membresías en el select
function cargarMembresias() {
    fetch('controlador/controladorRelacionM.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "OBTENERMEMBRESIAS" })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const selectMembresias = document.getElementById("ID_Membresia");
                selectMembresias.innerHTML = "<option value=''>Seleccione una membresía</option>";  // Opción por defecto

                data.membresias.forEach(membresia => {
                    const option = document.createElement("option");
                    option.value = membresia.ID_Membresia;
                    option.setAttribute("data-tipo", membresia.Duracion); 
                    option.textContent = membresia.Tipo;
                    option.setAttribute("data-precio", membresia.Costo);  // Guardamos el precio en un atributo
                    selectMembresias.appendChild(option);
                });
            } else {
                Swal.fire("Error", "No se pudieron cargar las membresías", "error");
            }
        })
        .catch(error => {
            Swal.fire("Error", "No se pudo cargar la lista de membresías: " + error.message, "error");
        });
}

// Llamar a la función cuando se cargue el formulario
document.addEventListener('DOMContentLoaded', function () {
    cargarMembresias();
});



