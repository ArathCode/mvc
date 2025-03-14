import { validaLargo, validaRango } from "./validaciones.js?v=3.7";

document.addEventListener("DOMContentLoaded", () => {
    let filtros = document.querySelectorAll(".filter");
    let fechaInicio = document.getElementById("fechaInicio");
    let fechaFin = document.getElementById("fechaFin");
    let btnFiltrar = document.getElementById("btnFiltrar");
    
    listarMiembros();

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
