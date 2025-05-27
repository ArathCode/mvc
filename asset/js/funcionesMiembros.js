import { validaLargo, validaRango, validaSoloLetras, validaTelefono,validaPin } from "./validaciones.js?v=3.9.1";

document.addEventListener("DOMContentLoaded", () => {
    let filtros = document.querySelectorAll(".filter");
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
        
    //Validaciones
    const nombre = document.getElementById('Nombre');
    const apellidoP = document.getElementById('ApellidoP');
    const apellidoM = document.getElementById('ApellidoM');

    function limitarEntradaLetras(event) {
        const input = event.target;
        const maxLength = 30;

        input.value = input.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóú\s]/g, ''); 
        if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength); 
        }
    }
    function limitAp(event) {
        const input = event.target;
        const maxLength = 15;

        input.value = input.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóú\s]/g, ''); 
        if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength); 
        }
    }

    nombre.addEventListener('input', limitarEntradaLetras);
    apellidoP.addEventListener('input', limitAp);
    apellidoM.addEventListener('input', limitAp);
        
        const formEditarUsuario = document.querySelector("#formEditarMiembro");
        if (formEditarUsuario) {
            formEditarUsuario.addEventListener("submit", (event) => {
                event.preventDefault();
                let erroresE = 0;
                let nombreE = document.querySelector("#NombreEdit");
                let ApellidoPE = document.querySelector("#ApellidoPEdit");
                let ApellidoME = document.querySelector("#ApellidoMEdit");
                let telE = document.querySelector("#TelefonoEdit");
                let pinE = document.querySelector("#pinEdit");
                
                if(!validaSoloLetras(nombreE))
                    erroresE++;
                if(!validaSoloLetras(ApellidoPE))
                    erroresE++;
                if(!validaSoloLetras(ApellidoME))
                    erroresE++;
                if(!validaTelefono(telE))
                    erroresE++;
                if(!validaPin(pinE))
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
    
});


let paginaActual = 1;
const registrosPorPagina = 10;

// Función para listar miembros (con o sin filtros)
export function listarMiembros(filtros = {}) {
    let params = new URLSearchParams();
    params.append("ope", "LISTARMIEMBROS");
    params.append("pagina", paginaActual);
    params.append("registrosPorPagina", registrosPorPagina);

    // Añadir filtros si están activos
    if (filtros.ID_Miembro) params.append("id", filtros.ID_Miembro);
    if (filtros.Nombre) params.append("nombre", filtros.Nombre);
    if (filtros.Apellidos) params.append("apellidos", filtros.Apellidos);
    if (filtros.Telefono) params.append("telefono", filtros.Telefono);

    fetch("../controlador/controladorMiembro.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString(),
    })
        .then((response) => response.json())
        .then((data) => {
            if (!data.success) {
                console.error("Error al cargar miembros:", data.msg);
                renderizarError("No se pudieron cargar los miembros.");
                return;
            }
            renderizarMiembros(data.lista); // Renderizar lista
            actualizarPaginacion(data.totalPaginas); // Actualizar paginación
        })
        .catch((error) => {
            console.error("Error en la solicitud:", error);
            renderizarError("Error al conectarse con el servidor.");
        });
}

// Renderizar miembros o mostrar mensaje si no hay resultados
function renderizarMiembros(lista) {
    const contenedor = document.querySelector("#ListaMiembros");
    contenedor.innerHTML = "";

    if (!lista || lista.length === 0) {
        // Mostrar mensaje de "No se encuentra ningún miembro"
        contenedor.innerHTML = `
            <div class="no-results">
                <p>No se encuentra ningún miembro con los filtros aplicados.</p>
            </div>
        `;
        return;
    }

    // Renderizar las tarjetas de los miembros
    lista.forEach((miembro) => {
        contenedor.innerHTML += `
            <div class="gasto-card">
                <p># ${miembro.ID_Miembro}</p>
                <h3>${miembro.Nombre} ${miembro.ApellidoP} ${miembro.ApellidoM}</h3>
                <p><strong>Teléfono:</strong> ${miembro.Telefono}</p>
                <p><strong>PIN:</strong> ${miembro.pin}</p>
                <p><strong>Sexo:</strong> ${miembro.Sexo}</p>
                <div class="card-buttons">
                    <button class="btn btn-warning btn-editar" id="btnEd" data-id="${miembro.ID_Miembro}" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                    <button class="btn btn-danger btn-eliminar" id="btnE" data-id="${miembro.ID_Miembro}">Eliminar</button>
                </div>
            </div>
        `;
    });
}

// Renderizar mensaje de error
function renderizarError(mensaje) {
    const contenedor = document.querySelector("#ListaMiembros");
    contenedor.innerHTML = `
        <div class="error-message">
            <p>${mensaje}</p>
        </div>
    `;
}

// Actualizar la paginación
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
        boton.addEventListener("click", () => {
            paginaActual = i;
            listarMiembros(); 
        });

        paginacion.appendChild(boton);
    }
}

function aplicarFiltros() {
    const filtros = {
        ID_Miembro: document.getElementById("idM").value.trim(),
        Nombre: document.getElementById("nombreM").value.trim(),
        Apellidos: document.getElementById("apeP").value.trim(),
        Telefono: document.getElementById("numM").value.trim(),
    };

    paginaActual = 1; 
    listarMiembros(filtros); 
}

document.addEventListener("DOMContentLoaded", () => {
    const filtersContainer = document.querySelector(".filter-container");

    if (!filtersContainer) {
        console.error("Error: No se encontró el contenedor de filtros.");
        return;
    }

    filtersContainer.addEventListener("input", aplicarFiltros);

    listarMiembros();
});

document.getElementById("limpiarM").addEventListener("click", function () {
    document.querySelectorAll(".filter input").forEach((input) => {
        input.value = "";
    });

    aplicarFiltros(); 
});

document.querySelectorAll(".filter").forEach(filter => {
    filter.addEventListener("click", function (event) {
        let isActive = this.classList.contains("active");

        document.querySelectorAll(".filter").forEach(otherFilter => {
            otherFilter.classList.remove("active");
            let inputs = otherFilter.querySelectorAll("input, select");
            inputs.forEach(input => {
                input.classList.add("hidden");
                input.value = "";
            });
        });

        if (!isActive) {
            this.classList.add("active");
            let input = this.querySelector("input, select");
            if (input) input.classList.remove("hidden");
        }
    });
});

document.querySelectorAll(".filter input").forEach(input => {
    input.addEventListener("click", function (event) {
        event.stopPropagation();
    });
});

document.querySelectorAll(".filter .close").forEach(button => {
    button.addEventListener("click", function (event) {
        event.stopPropagation();
        let filter = this.parentElement;
        filter.classList.remove("active");

        let inputs = filter.querySelectorAll("input, select");
        inputs.forEach(input => {
            input.classList.add("hidden");
            input.value = "";
        });
    });
});


document.getElementById("limpiarM").addEventListener("click", function () {
    document.querySelectorAll(".filter").forEach(filter => {
        let input = filter.querySelector("input");
        input.classList.add("hidden");
        input.value = "";
        filter.classList.remove("active");
    });
});





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
        confirmButtonColor: "#8d2e27",
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
             document.querySelector("#pinEdit").value = data.miembro.pin;

        } else {
            Swal.fire("Error", "No se pudo obtener la información del usuario", "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo obtener la información del usuario: " + error.message, "error");
    });
}