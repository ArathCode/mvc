document.addEventListener("DOMContentLoaded", () => {
    const botones = document.querySelectorAll('.filter-container .filter');
    setupCloseButton();

    //Editar
    let promoEditandoId = null;
    const modalEditar = document.querySelector("#editarPromo");
    if (modalEditar) {
        modalEditar.addEventListener("hidden.bs.modal", limpiarFormularioEditar);
    }
    
    const btnGuardar = document.querySelector("#btnGuardarE");
    if (btnGuardar) {
        btnGuardar.addEventListener("click", function(e) {
            e.preventDefault();
            guardarEdicionPromocion();
            
        });
        
    }
    
    const btnCancelar = document.querySelector("#btnCancelar");
    if (btnCancelar) {
        btnCancelar.addEventListener("click", limpiarFormularioEditar);
    }

    botones.forEach(boton => {
        boton.addEventListener('click', () => {
            botones.forEach(b => b.classList.remove('active'));

            boton.classList.add('active');

            if (boton.classList.contains('promosAct')) {
                listarPromocionesActivas();
            } else if (boton.classList.contains('promosInact')) {
                listarPromocionesInactivas();
            } else {
                listarPromociones(); 
            }
        });
    });
    document.querySelector('.promosTodas').click();
    
    
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
                        <div class="promo-item ${promo.is_active == 1 ? '' : 'inactive'}" 
                            onclick="handlePromoClick(this, ${JSON.stringify(promo).replace(/"/g, '&quot;')})">
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
                                    <button class="btn btn-edit" onclick="event.stopPropagation(); editPromo('${promo.id}')" 
                                    data-bs-toggle="modal" data-bs-target="#editarPromo">
                                        Editar
                                    </button>
                                    ${promo.is_active == 1 ? 
                                        `<button class="btn btn-deactivate" onclick="event.stopPropagation(); togglePromo('${promo.id}', 0)">
                                            Desactivar
                                        </button>` : 
                                        `<button class="btn btn-activate" onclick="event.stopPropagation(); togglePromo('${promo.id}', 1)">
                                            Activar
                                        </button>`
                                    }
                                    <button class="btn btn-delete" onclick="event.stopPropagation(); deletePromo('${promo.id}')">
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

    function listarPromocionesActivas() {
        fetch('../controlador/controladorPromo.php', {
            method: 'POST',
            body: new URLSearchParams({ "ope": "LISTAR_ACTIVAS" })
        })
        .then(response => response.json())
        .then(data => renderizarPromos(data))
        .catch(error => console.error("Error al cargar promociones activas:", error));
    }

    function listarPromocionesInactivas() {
        fetch('../controlador/controladorPromo.php', {
            method: 'POST',
            body: new URLSearchParams({ "ope": "LISTAR_INACTIVAS" })
        })
        .then(response => response.json())
        .then(data => renderizarPromos(data))
        .catch(error => console.error("Error al cargar promociones inactivas:", error));
    }

    function renderizarPromos(data) {
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
                                <button class="btn btn-edit" onclick="editPromo('${promo.id}')" 
                                data-bs-toggle="modal" data-bs-target="#editarPromo">
                                    Editar
                                </button>
                                ${promo.is_active == 1 ? 
                                    `<button class="btn btn-deactivate" onclick="togglePromo('${promo.id}', 0)">
                                        Desactivar
                                    </button>` : 
                                    `<button class="btn btn-activate" onclick="togglePromo('${promo.id}', 1)">
                                        Activar
                                    </button>`
                                }
                                <button class="btn btn-delete" onclick="deletePromo('${promo.id}')">
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
    location.reload();
});
    
    listarPromociones(); 

});

//Editar promos
function editPromo(promoId) {
    promoEditandoId = promoId;
    
    cargarUsuariosEditar();
    
    const datos = new FormData();
    datos.append("ope", "OBTENER");
    datos.append("id", promoId);

    fetch('../controlador/controladorPromo.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.promo) {
            llenarFormularioEditar(data.promo);
        } else {
            Swal.fire("Error", data.msg || "No se pudieron cargar los datos de la promoción", "error");
        }
    })
    .catch(error => {
        console.error("Error al obtener promoción:", error);
        Swal.fire("Error", "Error de red: " + error.message, "error");
    });
}

function llenarFormularioEditar(promo) {
    document.querySelector("#nombrePromoE").value = promo.title || '';
    document.querySelector("#descripcionE").value = promo.description || '';
    document.querySelector("#ofertaE").value = promo.offer_text || '';
    document.querySelector("#categoriaE").value = promo.category || '';
    document.querySelector("#terminosE").value = promo.terms || '';
    document.querySelector("#estadoE").value = promo.is_active || '0';
    
    if (promo.valid_until) {
        const fecha = new Date(promo.valid_until);
        const fechaFormateada = fecha.toISOString().split('T')[0];
        document.querySelector("#fechaValidezE").value = fechaFormateada;
    }
    
    setTimeout(() => {
        if (promo.ID_Usuario) {
            document.querySelector("#usuarioAsignadoE").value = promo.ID_Usuario;
        }
    }, 100);
}

function cargarUsuariosEditar() {
    const datos = new FormData();
    datos.append("ope", "LISTAR_USUARIOS");

    fetch('../controlador/controladorPromo.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(usuarios => {
        const select = document.querySelector("#usuarioAsignadoE");
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

function guardarEdicionPromocion() {
    if (!promoEditandoId) {
        Swal.fire("Error", "No se ha seleccionado una promoción para editar", "error");
        return;
    }

    const title = document.querySelector("#nombrePromoE").value.trim();
    const description = document.querySelector("#descripcionE").value.trim();
    const offer_text = document.querySelector("#ofertaE").value.trim();
    
    if (!title || !description || !offer_text) {
        Swal.fire("Error", "Por favor complete los campos obligatorios: Nombre, Descripción y Oferta", "error");
        return;
    }

    const datos = new FormData();
    datos.append("ope", "EDITAR");
    datos.append("id", promoEditandoId);
    datos.append("title", title);
    datos.append("subtitle", title);
    datos.append("offer_text", offer_text);
    datos.append("description", description);
    datos.append("terms", document.querySelector("#terminosE").value.trim());
    datos.append("valid_until", document.querySelector("#fechaValidezE").value);
    datos.append("category", document.querySelector("#categoriaE").value.trim());
    datos.append("is_active", document.querySelector("#estadoE").value);
    datos.append("ID_Usuario", document.querySelector("#usuarioAsignadoE").value);

    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('../controlador/controladorPromo.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        
        if (data.success) {
            Swal.fire("Éxito", "Promoción actualizada correctamente", "success").then(() => {
                document.querySelector("#editarPromo .btn-close").click();
                location.reload();
                promoEditandoId = null;
            });
        } else {
            Swal.fire("Error", data.msg || "No se pudo actualizar la promoción", "error");
        }
    })
    .catch(error => {
        Swal.close();
        console.error("Error al actualizar promoción:", error);
        Swal.fire("Error", "Error de red: " + error.message, "error");
    });
}

function limpiarFormularioEditar() {
    document.querySelector("#promoFormE").reset();
    promoEditandoId = null;
}



function renderizarPromos(data) {
    const contenedor = document.querySelector(".promoCard");
    contenedor.innerHTML = "";

    if (data.success && data.lista.length > 0) {
        data.lista.forEach(promo => {
            contenedor.innerHTML += `
                <div class="promo-item ${promo.is_active == 1 ? '' : 'inactive'}" 
                     onclick="handlePromoClick(this, ${JSON.stringify(promo).replace(/"/g, '&quot;')})">
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
                            <button class="btn btn-edit" onclick="event.stopPropagation(); editPromo('${promo.id}')" 
                            data-bs-toggle="modal" data-bs-target="#editarPromo">
                                Editar
                            </button>
                            ${promo.is_active == 1 ? 
                                `<button class="btn btn-deactivate" onclick="event.stopPropagation(); togglePromo('${promo.id}', 0)">
                                    Desactivar
                                </button>` : 
                                `<button class="btn btn-activate" onclick="event.stopPropagation(); togglePromo('${promo.id}', 1)">
                                    Activar
                                </button>`
                            }
                            <button class="btn btn-delete" onclick="event.stopPropagation(); deletePromo('${promo.id}')">
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
}


//Eliminar promos
function deletePromo(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Esta acción eliminará la promoción.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('../controlador/controladorPromo.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "ELIMINAR", "id": id })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire(
            '¡Eliminado!',
            'Promoción eliminada correctamente.',
            'success'
          ).then(() => {
            location.reload();
          });
        } else {
          Swal.fire(
            'Error',
            'Error al eliminar la promoción.',
            'error'
          );
        }
      })
      .catch(error => {
        console.error("Error al eliminar:", error);
        Swal.fire(
          'Error',
          'Ocurrió un error al eliminar.',
          'error'
        );
      });
    }
  });
}




function handlePromoClick(element, promoData) {
    document.querySelectorAll('.promo-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    element.classList.add('selected');
    
    showPromoPreview(promoData);
}

function attachPromoEvents(promosList) {
    const promoItems = document.querySelectorAll('.promo-item');
    
    promoItems.forEach((item, index) => {
        item.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON') {
                return;
            }
            
            document.querySelectorAll('.promo-item').forEach(el => {
                el.classList.remove('selected');
            });
            
            this.classList.add('selected');
            
            showPromoPreview(promosList[index]);
        });
    });
}

function setupCloseButton() {
    const closeButton = document.querySelector('.close-button');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            const promoCard = document.querySelector('.promo-card');
            if (promoCard) {
                promoCard.style.transition = 'all 0.3s ease';
                promoCard.style.opacity = '0';
                promoCard.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    promoCard.style.display = 'none';
                    document.querySelectorAll('.promo-item').forEach(item => {
                        item.classList.remove('selected');
                    });
                }, 300);
            }
        });
    }
}



function showPromoPreview(promoData) {
        const promoCard = document.querySelector('.promo-card');
        
        if (!promoCard) {
            console.error('No se encontró el elemento .promo-card');
            return;
        }

        const promoBadge = promoCard.querySelector('.promo-badge');
        if (promoBadge) {
            promoBadge.textContent = promoData.offer_text || 'Oferta especial';
        }

        const promoTitle = promoCard.querySelector('.promo-info h3');
        if (promoTitle) {
            promoTitle.textContent = promoData.title || 'Título de la promo';
        }

        const promoSubtitle = promoCard.querySelector('.promo-info p');
        if (promoSubtitle) {
            promoSubtitle.textContent = promoData.subtitle || 'Subtítulo';
        }

        const description = promoCard.querySelector('.description p');
        if (description) {
            description.textContent = promoData.description || 'Descripción no disponible';
        }

        const terms = promoCard.querySelector('.terms p');
        if (terms) {
            terms.textContent = promoData.terms || 'Términos y condiciones';
        }

        const validity = promoCard.querySelector('.validity span:last-child');
        if (validity) {
            const validUntil = promoData.valid_until ? 
                new Date(promoData.valid_until).toLocaleDateString('es-ES') : 
                'Fecha no disponible';
            validity.textContent = `Válido hasta: ${validUntil}`;
        }

        const barcodeNumber = promoCard.querySelector('.barcode-number');
        if (barcodeNumber) {
            barcodeNumber.textContent = `#${promoData.id}`;
        }

        promoCard.style.display = 'block';
        
        promoCard.style.opacity = '0';
        promoCard.style.transform = 'translateY(20px)';
        setTimeout(() => {
            promoCard.style.transition = 'all 0.3s ease';
            promoCard.style.opacity = '1';
            promoCard.style.transform = 'translateY(0)';
        }, 10);
    }
