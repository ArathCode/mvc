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
                        <div class="promo-item">
                        <h3>Codigo:  ${promo.id}</h3>
                            <h3>${promo.title}</h3>
                            <h4>${promo.subtitle}</h4>
                            <p><strong>Oferta:</strong> ${promo.offer_text}</p>
                            <p>${promo.description}</p>
                            <p><strong>Términos:</strong> ${promo.terms}</p>
                            <p><strong>Válido hasta:</strong> ${promo.valid_until}</p>
                            <p><strong>Categoría:</strong> ${promo.category}</p>
                            <p><strong>Estado:</strong> ${promo.is_active == 1 ? 'Activa' : 'Inactiva'}</p>
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

    listarPromociones(); 

});
