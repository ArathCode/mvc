<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corte de Caja - Dragon's Gym</title>
    <?php include_once("head.php"); ?>
    
    <link rel="stylesheet" href="../asset/css/corte.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body>

    <!-- =============== Barra de navegacion ================ -->
    <div class="navigation">
        <?php
        include_once("encabezado.php")
            ?>
    </div>

    <div class="main">  
        <div class="topbar">
            <div class="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>

            


            <div class="contenedor">
                <div class="notificacion" onclick="toggleNotifi()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                    </svg>
                </div>
                <div class="usuario">
                    <img src="https://i.pinimg.com/originals/a0/14/7a/a0147adf0a983ab87e86626f774785cf.gif" alt="">
                </div>
                <div class="notifi-box" id="box">
                    <p class="calendario"></p>
                    <div class="notifi-item">
                        <div class="text">
                            <h4>Notificaciones</h4>
                        </div>
                        <div class="calend">
                            <div class="calend">
                                <div class="calendar">
                                    <div class="calendar-header">
                                        <button id="prev">&lt;</button>
                                        <h3></h3>
                                        <button id="next">&gt;</button>
                                    </div>
                                    <ul class="weekdays">
                                        <li>Dom</li>
                                        <li>Lun</li>
                                        <li>Mar</li>
                                        <li>Mié</li>
                                        <li>Jue</li>
                                        <li>Vie</li>
                                        <li>Sáb</li>
                                    </ul>
                                    <ul class="dates"></ul>
                                </div>
                            </div>
                        </div>
                        <div class="noti">
                            <table>
                                <tr>
                                    <td>
                                        <h4>Sin notificaciones...<br></h4>
                                    </td>
                                </tr>
                                
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <h2>Corte de Caja - Dragon's Gym</h2>
        <div class="centrar">
            <div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Asignar Rutinas a Miembros</h5>
            <div class="input-group w-50">
                <input type="text" class="form-control" id="busquedaID" placeholder="Buscar por ID del miembro">
                <button class="btn btn-light" id="buscarMiembro">Buscar</button>
            </div>
        </div>
        <div class="card-body">
            <form id="formRutina">
                <input type="hidden" id="ID_MiembroRutina" name="ID_Miembro">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="Lunes" class="form-label">Lunes</label>
                        <select class="form-select rutina-select" id="Lunes"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="Martes" class="form-label">Martes</label>
                        <select class="form-select rutina-select" id="Martes"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="Miercoles" class="form-label">Miércoles</label>
                        <select class="form-select rutina-select" id="Miercoles"></select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="Jueves" class="form-label">Jueves</label>
                        <select class="form-select rutina-select" id="Jueves"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="Viernes" class="form-label">Viernes</label>
                        <select class="form-select rutina-select" id="Viernes"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="Sabado" class="form-label">Sábado</label>
                        <select class="form-select rutina-select" id="Sabado"></select>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" id="btnGuardarRutina" class="btn btn-success">Guardar Rutina</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para cargar entrenamientos y lógica -->
<script>
    // Cargar opciones desde PHP (puedes reemplazar con AJAX si quieres que sea dinámico)
    const cargarEntrenamientos = () => {
        $.ajax({
            url: "controlador/controladorEntrenamientos.php", // debes crear este para listar
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
</script>

<script src="../asset/js/funcionesRutinas.js?v=4.9.4"></script>
        </div>
        
        
    </div>
    

    <script src="../asset/js/notificaciones.js"></script>
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/calendario.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


</body>
</html>
