document.addEventListener("DOMContentLoaded", () => {
    listarAccesos();

    const formAgregar = document.querySelector("#miModal form");
    formAgregar.addEventListener("submit", (event) => {
        event.preventDefault();
        agregarAcceso();
    });

    const searchInput = document.querySelector("#searchInput");
    searchInput.addEventListener("input", () => {
        buscarMiembro(searchInput.value);
    });
});

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
    .catch(error => console.error("Error:", error));
}

function agregarAcceso() {
    const form = document.querySelector("#miModal form");
    const datos = new FormData(form);
    datos.append("ope", "AGREGAR_ACCESO");

    fetch('controlador/controladorAcceso.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Acceso agregado correctamente", "success");
            form.reset();
            document.querySelector("#miModal .btn-close").click();
            listarAccesos();
        } else {
            Swal.fire("Error", "No se pudo agregar el acceso", "error");
        }
    })
    .catch(error => console.error("Error:", error));
}

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
    .catch(error => console.error("Error:", error));
}
