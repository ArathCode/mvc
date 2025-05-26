$(document).ready(function () {
    // Al hacer clic en el botón de guardar rutina
    $('#btnGuardarRutina').on('click', function (e) {
    e.preventDefault();

    const ID_Miembro = $('#busquedaID').val();

    if (ID_Miembro === "") {
        Swal.fire("Atención", "Ingresa el ID del miembro", "warning");
        return;
    }

    const dias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
    const promesas = [];

    dias.forEach(function (dia) {
        const entrenamientoID = $(`#${dia}`).val();

        if (entrenamientoID !== "") {
            const promesa = $.post('controlador/controladorRutinas.php', {
                ope: 'ASIGNAR',
                ID_Miembro: ID_Miembro,
                Dia: dia,
                ID_Entrenamiento: entrenamientoID
            }, 'json');

            promesas.push(promesa);
        }
    });

    // Espera a que todas las asignaciones terminen
    Promise.all(promesas)
        .then(function (respuestas) {
            let huboError = false;

            respuestas.forEach(function (respuesta) {
                if (!respuesta.success) {
                    huboError = true;
                    console.error("Error en asignación:", respuesta);
                }
            });

            if (huboError) {
                Swal.fire("Error", "Ocurrió un error al guardar alguna rutina", "error");
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Rutina guardada',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        })
        .catch(function (error) {
            console.error("Error general:", error);
            Swal.fire("Error", "No se pudo completar la operación", "error");
        });
});


    // Buscar rutinas existentes al seleccionar miembro
    $("#buscarMiembro").click(function () {
    const id = $("#busquedaID").val();

    if (id === "") {
        Swal.fire("Atención", "Ingresa el ID del miembro", "warning");
        return;
    }

    $.ajax({
        url: "controlador/controladorRutinas.php",
        type: "POST",
        data: {
            ope: "OBTENER_RUTINA",
            ID_Miembro: id
        },
        dataType: "json",
        success: function (res) {
            $("#NombreMiembro").text("Miembro: " + res.nombre).show();
            if (res.success && res.rutina) {
                $("#ID_MiembroRutina").val(id);
                
                // Llena todos los días
                $("#Lunes").val(res.rutina.Lunes);
                $("#Martes").val(res.rutina.Martes);
                $("#Miercoles").val(res.rutina.Miercoles);
                $("#Jueves").val(res.rutina.Jueves);
                $("#Viernes").val(res.rutina.Viernes);
                $("#Sabado").val(res.rutina.Sabado);
                 
            } else {
                Swal.fire("Error", "No se encontró la rutina", "error");
            }
        }
    });
});
});
