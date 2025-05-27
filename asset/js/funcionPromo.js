document.addEventListener("DOMContentLoaded", () => {
    
    
    
    function listarPromociones() {
        fetch('../controlador/controladorPromo.php', {
            method: 'POST',
            body: new URLSearchParams({ "ope": "LISTAR_TODAS" })
        })
        .then(response => response.json())
        .then(data => {
            const contenedor = document.querySelector(".promoCard");
            contenedor.innerHTML = "";

            if (data.success && data.lista.length > 0) {
                data.lista.forEach(promo => {
                    contenedor.innerHTML += `
                        <div class="promo-item ${promo.is_active == 1 ? '' : 'inactive'}">
                            <h3>${promo.title}</h3>
                            <h4>${promo.subtitle}</h4>
                            <p>Codigo: ${promo.id}</p>
                            <p><strong>Oferta:</strong> ${promo.offer_text}</p>
                            <p>${promo.description}</p>
                            <p><strong>Términos:</strong> ${promo.terms}</p>
                            <p><strong>Válido hasta:</strong> ${promo.valid_until}</p>
                            <p><strong>Categoría:</strong> ${promo.category}</p>
                            
                            <div class="status-container">
                                <div class="action-buttons">
                                    <button class="btn btn-edit" onclick="editPromo(${promo.id})">
                                        Editar
                                    </button>
                                    ${promo.is_active == 1 ? 
                                        `<button class="btn btn-deactivate" onclick="togglePromo(${promo.id}, 0)">
                                            Desactivar
                                        </button>` : 
                                        `<button class="btn btn-activate" onclick="togglePromo(${promo.id}, 1)">
                                            Activar
                                        </button>`
                                    }
                                    <button class="btn btn-delete" onclick="deletePromo(${promo.id})">
                                        Eliminar
                                    </button>
                                </div>
                                <p class="status-text">
                                    <strong>Estado:</strong> ${promo.is_active == 1 ? 'Activa' : 'Inactiva'}
                                </p>
                            </div>
                        </div>
                    `;
                });
            } else {
                contenedor.innerHTML = "<p>No hay promociones disponibles.</p>";
            }
        })
        .catch(error => {
            console.error("Error al cargar promociones:", error);
        });
    }



    function agregarPromocion() {
    const form = document.querySelector("#promoForm");
    const datos = new FormData();

    datos.append("ope", "AGREGAR");
    datos.append("title", document.querySelector("#nombrePromo").value);
    datos.append("subtitle", document.querySelector("#descripcion").value);
    datos.append("offer_text", document.querySelector("#oferta").value);
    datos.append("description", document.querySelector("#descripcion").value);
    datos.append("terms", document.querySelector("#terminos").value);
    datos.append("valid_until", document.querySelector("#fechaValidez").value);
    datos.append("category", document.querySelector("#categoria").value);
    datos.append("is_active", document.querySelector("#estado").value);
    datos.append("ID_Usuario", document.querySelector("#usuarioAsignado").value);

    fetch('../controlador/controladorPromo.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Promoción agregada correctamente", "success");
            form.reset();
            document.querySelector("#agregarPromo .btn-close").click();
        } else {
            Swal.fire("Error", data.msg || "No se pudo agregar la promoción", "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "Error de red: " + error.message, "error");
    });
}
function cargarUsuarios() {
    const datos = new FormData();
    datos.append("ope", "LISTAR_USUARIOS");

    fetch('../controlador/controladorPromo.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(usuarios => {
        const select = document.querySelector("#usuarioAsignado");
        select.innerHTML = '<option value="">Seleccionar...</option>';
        usuarios.forEach(usuario => {
            const option = document.createElement("option");
            option.value = usuario.ID_Usuario;
            option.textContent = usuario.nombre_completo;
            select.appendChild(option);
        });
    })
    .catch(error => {
        console.error("Error al cargar usuarios:", error);
    });
}

document.querySelector("#agregarPromo").addEventListener("show.bs.modal", cargarUsuarios);
document.querySelector("#promoForm").addEventListener("submit", function(e) {
    e.preventDefault();
    agregarPromocion();
    listarPromociones(); 
});
    
    listarPromociones(); 

});
