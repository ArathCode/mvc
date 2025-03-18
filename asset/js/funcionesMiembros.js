import { validaLargo, validaRango, validaSoloLetras, validaTelefono } from "./validaciones.js?v=3.8";

document.addEventListener("DOMContentLoaded", () => {
    let filtros = document.querySelectorAll(".filter");
    let fechaInicio = document.getElementById("fechaInicio");
    let fechaFin = document.getElementById("fechaFin");
    let btnFiltrar = document.getElementById("btnFiltrar");
     const listaUsuarios = document.querySelector("#ListaMiembros");
        if (listaUsuarios) {
            listaUsuarios.addEventListener("click", (event) => {
                event.preventDefault();
                const target = event.target;
    
                if (target.classList.contains("btn-editar")) {
                    cargarMiembro(target.dataset.id);
                } else if (target.classList.contains("btn-eliminar")) {
                    eliminarMiembro(target.dataset.id);
                }
                
            });
            
        }
    
        
        const formEditarUsuario = document.querySelector("#formEditarMiembro");
        if (formEditarUsuario) {
            formEditarUsuario.addEventListener("submit", (event) => {
                event.preventDefault();
                let erroresE = 0;
                let nombreE = document.querySelector("#NombreEdit");
                let ApellidoPE = document.querySelector("#ApellidoPEdit");
                let ApellidoME = document.querySelector("#ApellidoMEdit");
                let telE = document.querySelector("#TelefonoEdit");
                
                if(!validaSoloLetras(nombreE))
                    erroresE++;
                if(!validaSoloLetras(ApellidoPE))
                    erroresE++;
                if(!validaSoloLetras(ApellidoME))
                    erroresE++;
                if(!validaTelefono(telE))
                    erroresE++;

                if(erroresE==0)
                    editarUsuario();
            });
        }
        
    listarMiembros();
    const formUsuario = document.querySelector("#formAgregarMiembro");
        if (formUsuario) {
            formUsuario.addEventListener("submit", (event) => {
                event.preventDefault();
                let errores = 0; 
                 
                    let nombre = document.querySelector("#Nombre");
                    let ApellidoP = document.querySelector("#ApellidoP");
                    let ApellidoM = document.querySelector("#ApellidoM");
                    let correo = document.querySelector("#Sexo");
                    let tel = document.querySelector("#Telefono");
    
                    if(!validaSoloLetras(nombre))
                        errores++;
                    if(!validaSoloLetras(ApellidoP))
                        errores++;
                    if(!validaSoloLetras(ApellidoM))
                        errores++;
                    if(!validaTelefono(tel))
                        errores++;
                    
                    if(errores==0)
                        agregarUsuario();
            });
        }
    filtros.forEach(filtro => {
        filtro.addEventListener("click", function () {
            filtros.forEach(f => f.classList.remove("active"));
            this.classList.add("active");
    
            const today = new Date();
    
            if (this.dataset.filter === "hoy") {
                const hoy = today.toISOString().split("T")[0];
                fechaInicio.value = hoy;
                fechaFin.value = hoy;
                listarMiembros();
            } else if (this.dataset.filter === "mes") {
                const año = new Date().getFullYear();
                const mes = (today.getMonth() + 1).toString().padStart(2, "0");
                fechaInicio.value = `${año}-${mes}-01`;
                fechaFin.value = new Date(año, mes, 0).toISOString().split("T")[0];
                listarMiembros();
            }
        });
    });

    document.getElementById("limpiarM").addEventListener("click", function () {
        filtros.forEach(filtro => filtro.classList.remove("active"));
        fechaInicio.value = "";
        fechaFin.value = "";
        listarMiembros();
    });

    btnFiltrar.addEventListener("click", function () {
        if (!fechaInicio.value || !fechaFin.value) {
            alert("Por favor, seleccione ambas fechas.");
            return;
        }
        if (fechaInicio.value > fechaFin.value) {
            alert("La fecha de inicio no puede ser mayor que la fecha de fin.");
            return;
        }
        listarMiembros();
    });
});
let paginaActual = 1;
const registrosPorPagina = 10;

export function listarMiembros() {
  

    let params = new URLSearchParams();
    params.append("ope", "LISTARMIEMBROS");
    params.append("pagina", paginaActual);
    params.append("registrosPorPagina", registrosPorPagina);
   

    fetch('../controlador/controladorMiembro.php', {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error("Error al cargar miembros:", data.error);
            return;
        }
        renderizarMiembros(data.lista);
        actualizarPaginacion(data.totalPaginas);
    })
    .catch(error => {
        console.error("Error en la carga de miembros:", error);
    });
}

function renderizarMiembros(lista) {
    const contenedor = document.querySelector("#ListaMiembros");
    contenedor.innerHTML = "";

    if (!lista || lista.length === 0) {
        contenedor.innerHTML = "<p>No hay miembros en este rango de fechas.</p>";
        return;
    }

    lista.forEach(miembro => {
        contenedor.innerHTML += `
            <div class="gasto-card">
                <h3>${miembro.Nombre} ${miembro.ApellidoP} ${miembro.ApellidoM}</h3>
                <p><strong>Teléfono:</strong> ${miembro.Telefono}</p>
                <p><strong>Sexo:</strong> ${miembro.Sexo}</p>
                <div class="card-buttons">
                    <button class="btn btn-warning btn-editar" data-id="${miembro.ID_Miembro}" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                    <button class="btn btn-danger btn-eliminar" data-id="${miembro.ID_Miembro}">Eliminar</button>
                </div>
            </div>
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
    listarMiembros(); 
}
function agregarUsuario() {
    const form = document.querySelector("#formAgregarMiembro");
    const datos = new FormData(form);
    datos.append("ope", "AGREGAR");

    fetch('controlador/controladorMiembro.php', {
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
            listarMiembros();
            
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo agregar el usuario: " + error.message, "error");
    });
}
function editarUsuario() {
    const form = document.querySelector("#formEditarMiembro");
    const datos = new FormData(form);
    datos.append("ope", "EDITAR");

    fetch('controlador/controladorMiembro.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Usuario actualizado correctamente", "success");
            document.querySelector("#modalEditar .btn-close").click(); 
            listarMiembros();
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo actualizar el usuario: " + error.message, "error");
    });
}
function eliminarMiembro(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción no se puede deshacer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('controlador/controladorMiembro.php', {
                method: 'POST',
                body: new URLSearchParams({ "ope": "ELIMINAR", "ID_Miembro": id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Eliminado", "Usuario eliminado correctamente", "success");
                    listarMiembros();
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
function cargarMiembro(id) {
    fetch('controlador/controladorMiembro.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "OBTENER", "ID_Miembro": id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector("#ID_Miembro").value = data.miembro.ID_Miembro;
            document.querySelector("#NombreEdit").value = data.miembro.Nombre;
            document.querySelector("#ApellidoPEdit").value = data.miembro.ApellidoP;
            document.querySelector("#ApellidoMEdit").value = data.miembro.ApellidoM;
            document.querySelector("#SexoEdit").value = data.miembro.Sexo;
            document.querySelector("#TelefonoEdit").value = data.miembro.Telefono;

        } else {
            Swal.fire("Error", "No se pudo obtener la información del usuario", "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo obtener la información del usuario: " + error.message, "error");
    });
}