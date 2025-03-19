document.addEventListener("DOMContentLoaded", () => {
     // Asignar la fecha actual
     const inputFecha = document.getElementById("fecha");

    function establecerFechaActual() {
    const hoy = new Date();  
    hoy.setMinutes(hoy.getMinutes() - hoy.getTimezoneOffset());  

    const fechaFormateada = hoy.toISOString().split('T')[0];  
    document.getElementById("fecha").value = fechaFormateada;  
}


    const modal = document.getElementById("miModal");
    modal.addEventListener("show.bs.modal", () => {
        establecerFechaActual();
    });
 

    listarAccesos();

    // Evento para el formulario de agregar acceso
    const formAgregar = document.querySelector("#formAgregarAcceso");
    formAgregar.addEventListener("submit", (event) => {
        event.preventDefault();
        agregarAcceso();
    });

    // Evento para el botón de guardar acceso en el modal
    const btnGuardarAcceso = document.querySelector("#btnGuardarAcceso");
    btnGuardarAcceso.addEventListener("click", () => {
        agregarAcceso();
    });

    // Buscar miembro en el modal
    const idMiembroInput = document.querySelector("#idMiembro");
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

    // Buscar miembros con el input general de búsqueda
    const searchInput = document.querySelector("#searchInput");
    searchInput.addEventListener("input", () => {
        buscarMiembro(searchInput.value);
    });
});
//Limpiar filtros
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

        document.getElementById("fechaInicio").value = "";
        document.getElementById("fechaFin").value = "";

        listarGastos(); 
    });
});
// Función para listar accesos
function listarAccesos() {
    fetch('controlador/controladorAcceso.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "LISTAR_ACCESOS" })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const tbody = document.querySelector("#tablaAccesos tbody");
            tbody.innerHTML = "";
            data.accesos.forEach(acceso => {
                tbody.innerHTML += `
                <tr>
                    <td>${acceso.ID_Miembro}</td>
                    <td>${acceso.Nombre} ${acceso.ApellidoP} ${acceso.ApellidoM}</td>
                    <td>${acceso.Hora}</td>
                    <td>${acceso.Precio}</td>
                    <td>${acceso.Fecha}</td>
                </tr>
                `;
            });
        } else {
            console.error("Error al listar accesos.");
        }
    })
    .catch(error => console.error("Error al listar accesos:", error));
}

// Función para agregar acceso
function agregarAcceso() {
    const form = document.querySelector("#formAgregarAcceso");
    const inputFecha = document.getElementById("fecha");
    const datos = new FormData(form);

    // Validar que todos los campos estén llenos
    let camposVacios = false;
    for (let valor of datos.values()) {
        if (valor.trim() === "") {
            camposVacios = true;
            break;
        }
    }

    if (camposVacios) {
        Swal.fire({
            title: "Campos incompletos",
            text: "Por favor, rellena todos los campos antes de continuar.",
            icon: "warning",
            confirmButtonColor: "#108d08"
        });
        return;
    }

    Swal.fire({
        title: "¿Los datos son correctos?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#108d08",
        cancelButtonColor: "#8d2e27",
        confirmButtonText: "Sí, agregar visita"
    }).then((result) => {
        if (result.isConfirmed) {
            datos.append("ope", "AGREGAR_ACCESO");

            fetch('controlador/controladorAcceso.php', {
                method: 'POST',
                body: datos
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Éxito", "Visita agregada correctamente", "success");
                    form.reset();
                    document.querySelector("#miModal .btn-close").click(); 
                    listarAccesos(); 
                } else {
                    Swal.fire("Error", "No se pudo agregar el acceso", "error");
                }
            })
            .catch(error => console.error("Error al agregar acceso:", error));
        }
    });
}

// Función para buscar un miembro en el contenedor principal
function buscarMiembro(id) {
    if (id.trim() === "") return;

    fetch('controlador/controladorAcceso.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "BUSCAR_MIEMBRO", "ID_Miembro": id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const miembro = data.miembro;
            const contenidoM = document.querySelector(".contenidoM");
            contenidoM.innerHTML = `
                <p>#${miembro.ID_Miembro}</p>
                <h3>${miembro.Nombre} ${miembro.ApellidoP} ${miembro.ApellidoM}</h3>
                <p>Teléfono: ${miembro.Telefono}</p>
                <p>Sexo: ${miembro.Sexo}</p>
            `;
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => console.error("Error al buscar miembro:", error));
}
