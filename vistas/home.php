
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Home-DragonGym</title>
        <?php
        include_once("head.php");
        ?>
    <link rel="stylesheet" href="../asset/css/home.css">
    <script type="module" src="asset/js/acceso.js?v=1.8"></script>
    </head>

    <body>
        <!-- =============== Barra de navegacion ================ -->
        <div class="navigation">
            <?php
            include_once("encabezado.php")
                ?>
        </div>

        <!-- ========================= Contenido principal ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" id="searchInput" placeholder="Buscar miembro" >
                    </label>
                </div>


                <div class="contenedor">
                    <div class="notificacion" onclick="toggleNotifi()">
                        <ion-icon name="file-tray-full-outline"></ion-icon>
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

            <!-- ======================= Contadores ================== -->
            <div class="contadores">
                <div class="card d-flex align-items-center">
                    <div class="row w-100">
                        <!-- Columna 1 -->
                        <div class="col d-flex flex-column">
                        <div class="numbers">12</div>
                        <div class="cardName">Visitas</div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-auto d-flex align-items-center">
                        <div class="iconBx">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        </div>
                    </div>
                </div>


                <div class="card d-flex align-items-center">
                    <div class="row w-100">
                        <!-- Columna 1 -->
                        <div class="col d-flex flex-column">
                        <div class="numbers">4</div>
                        <div class="cardName">Miembros</div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-auto d-flex align-items-center">
                        <div class="iconBx">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        </div>
                    </div>
                </div>


                <div class="botonV">
                    <button class="agregarV" id="agregarVisitaBtn2" data-bs-toggle="modal" 
                    data-bs-target="#miModal"><span>Agregar visita</span></button>

                </div>

            </div>
            

            <!-- ================ Tabla de usuarios ================= -->
            <div class="details">
                <div class="registro">
                    <div class="cardHeader">
                        <h2>Lista de accesos</h2>
                        <a href="#" id="estadisticasBtn" class="btn">Gráfica</a>
                    </div>
                    <!-- ================ Modal de estadísticas ================= -->
                    <dialog id="modalEstadisticas">
                        <div class="modal-content">
<!-- si-->
                            <canvas id="myChart"></canvas>
                            <div>
                                <label for="filtro">Filtrar por:</label>
                                <select id="filtro">
                                    <option value="dia">Hoy</option>
                                    <option value="semana">Semana</option>
                                    <option value="mes">Mes</option>
                                </select>
                                <button id="cargarDatos">Cargar Datos</button>
                            </div>
                        </div>
                    </dialog>

                    <table  id="tablaAccesos">
                        <thead>
                            <tr>
                                <td>ID_Miembro</td>
                                <td>Nombre</td>
                                <td>Hora Entrada</td>
                                <td>Precio</td>
                                <td>Fecha</td>
                            </tr>
                        </thead>

                        <tbody >
                            
                        </tbody>

                    </table>
                </div>

                <!-- ================= Miembros ================ -->
                <div class="miembros">
                    <div class="titulo">
                        <h2>Miembros</h2>
                        <div class="huella">
                            <ion-icon name="finger-print-outline"></ion-icon>
                        </div>

                    </div>
                    <div class="fotoM">

                    </div>
                    <div class="contenidoM">
                        <p>#ID de miembro</p>
                        <h3>Nombre</h2>
                            <p>Número: </p>
                            <div class="fechas">
                                <div class="fechaI">
                                    dd/mm/yyyy
                                </div>
                                <div class="fechaF">
                                    dd/mm/yyyy
                                </div>
                            </div>
                            <div class="estadoM">
                                Membresía Activa
                            </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ===== Modal visita ===== -->
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Agregar Acceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarAcceso">
                            <div class="mb-3 d-flex align-items-center">
                                <div class="me-3 flex-grow-1">
                                    <label for="idMiembro" class="form-label">ID Miembro</label>
                                    <input type="number" class="form-control" id="idMiembro" name="ID_Miembro" placeholder="Escriba el ID" required>
                                </div>
                                <div class="flex-grow-2">
                                    <label for="nombreMiembro" class="form-label">Nombre del Miembro</label>
                                    <input type="text" class="form-control" id="nombreMiembro" placeholder="Nombre" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="Fecha" required readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio" name="Precio" placeholder="Ingrese el precio" min="0" max="300" required>
                                <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                            </div>
                            <input type="hidden" value="Visita" id="Tipo" name="Tipo">
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCerrar">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnGuardarAcceso">Guardar</button>

                    </div>
                </div>
            </div>
        </div>



        <script src="../asset/js/notificaciones.js"></script>
        <script src="../asset/js/main.js"></script>
        <script src="../asset/js/calendario.js"></script>
        
    </body>
</html>