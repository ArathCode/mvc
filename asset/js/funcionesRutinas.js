$(document).ready(function () {
    // Al hacer clic en el botón de guardar rutina
    $('#btnGuardarRutina').on('click', function (e) {
        e.preventDefault();

        const ID_Miembro = $('#ID_MiembroRutina').val();

        let datosCompletos = true;
        const dias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];

        dias.forEach(function (dia) {
            const entrenamientoID = $(`#${dia}`).val();

            if (entrenamientoID !== "") {
                $.post('controlador/controladorRutinas.php', {
                    ope: 'ASIGNAR',
                    ID_Miembro: ID_Miembro,
                    Dia: dia,
                    ID_Entrenamiento: entrenamientoID
                }, function (respuesta) {
                    if (!respuesta.success) {
                        datosCompletos = false;
                        console.error("Error asignando rutina para " + dia);
                    }
                }, 'json');
            }
        });

        Swal.fire({
            icon: 'success',
            title: 'Rutina guardada',
            showConfirmButton: false,
            timer: 1500
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
