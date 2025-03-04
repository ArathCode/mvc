import { validaCorreo, validaLargo, validaRango, validaSoloLetras, validaContrasena } from "./validaciones.js?v=3.7";
document.addEventListener("DOMContentLoaded", () => {
    listarUsuarios();

    // agregar usuario
    const formUsuario = document.querySelector("#formAgregar");
    if (formUsuario) {
        formUsuario.addEventListener("submit", (event) => {
            event.preventDefault();
            let errores = 0; 
             
                let nombre = document.querySelector("#Nombre");
                let ApellidoP = document.querySelector("#ApellidoP");
                let ApellidoM = document.querySelector("#ApellidoM");
                let correo = document.querySelector("#CorreoUsu");
                let clave = document.querySelector("#Contra");

                if(!validaSoloLetras(nombre))
                    errores++;
                if(!validaSoloLetras(ApellidoP))
                    errores++;
                if(!validaSoloLetras(ApellidoM))
                    errores++;
                if(!validaCorreo(correo))
                    errores++;
                if(!validaRango(clave,5,16))
                    errores++;
                if(!validaContrasena(clave))
                    errores++;
                
                if(errores==0)
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
            if(!validaRango(claveC,8,16))
                erroresC++;
            if(!validaRango(claveCC,8,16))
                erroresC++;
            if(!validaContrasena(claveC))
                erroresC++;
            if(!validaContrasena(claveCC))
                erroresC++;
            if(erroresC==0)
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
            
            if(!validaSoloLetras(nombreE))
                erroresE++;
            if(!validaSoloLetras(ApellidoPE))
                erroresE++;
            if(!validaSoloLetras(ApellidoME))
                erroresE++;
            if(!validaCorreo(correoE))
                erroresE++;
           
            if(erroresE==0)
                editarUsuario();
        });
    }
    
    
});

// Función para listar usuarios
function listarUsuarios() {
    fetch('controlador/controladorUsuarios.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "LISTAUSUARIOS" })
    })
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector("#ListaUsuarios tbody");
        tbody.innerHTML = "";
        data.lista.forEach(usuario => {
            tbody.innerHTML += `
            <tr>
                <td>${usuario.ID_Usuario}</td>
                <td>${usuario.Nombre}</td>
                <td>${usuario.ApellidoP}</td>
                <td>${usuario.ApellidoM}</td>
                <td>${usuario.NombreUsu}</td>
                <td>${usuario.Salario}</td>
                <td>${usuario.usutip}</td>
                <td>
                    <button class="btn btn-warning btn-editar" data-id="${usuario.ID_Usuario}" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                    <button class="btn btn-danger btn-eliminar" data-id="${usuario.ID_Usuario}">Eliminar</button>
                    <button class="btn btn-secondary btn-clave" data-id="${usuario.ID_Usuario}" data-bs-toggle="modal" data-bs-target="#modalEditarClave">Cambiar Clave</button>
                </td>
            </tr>
        `;
        });
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo cargar la lista de usuarios: " + error.message, "error");
    });
}


function agregarUsuario() {
    const form = document.querySelector("#formAgregar");
    const datos = new FormData(form);
    datos.append("ope", "AGREGAR");

    fetch('controlador/controladorUsuarios.php', {
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
    fetch('controlador/controladorUsuarios.php', {
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

    fetch('controlador/controladorUsuarios.php', {
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

    fetch("controlador/controladorUsuarios.php", {
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
            fetch('controlador/controladorUsuarios.php', {
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


