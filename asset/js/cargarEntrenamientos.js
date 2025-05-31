const cargarEntrenamientos = () => {
        $.ajax({
            url: "controlador/controladorEntrenamientos.php", 
            type: "POST",
            data: { ope: "LISTAR_ENTRENAMIENTOS" },
            dataType: "json",
            success: function (respuesta) {
                if (respuesta.success && respuesta.lista) {
                    $(".rutina-select").each(function () {
                        const select = $(this);
                        select.empty();
                        select.append('<option value="">Seleccione...</option>');
                        respuesta.lista.forEach(ent => {
                            select.append(`<option value="${ent.ID_Entrenamiento}">${ent.Nombre}</option>`);
                        });
                    });
                }
            }
        });
    };

    $(document).ready(function () {
        cargarEntrenamientos();
    });