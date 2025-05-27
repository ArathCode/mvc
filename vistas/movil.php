<!DOCTYPE html>
<html lang="en">
<head>
    <title>AppMovil-DragonGym</title>
    <?php
    include_once("head.php");
    ?>
    
    <link rel="stylesheet" href="../asset/css/movil.css">
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>
            <div class="subMenu">


                <div class="promos">
                    <div class="iconoPro">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 14.25 6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185ZM9.75 9h.008v.008H9.75V9Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008V13.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                    <div class="enlace">
                        <a href="index.php?pag=movil">Promociones</a>
                    </div>
                </div>


                <div class="rutina">
                    <div class="iconoRu">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                        </svg>
                    </div>
                    <div class="enlace">
                        <a href="index.php?pag=rutinas">Rutinas</a>
                    </div>
                </div>
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
        

        <div class="contenido">
            <div class="promocionesL">
                <div class="gB">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarPromo">
                        Agregar Promoción
                    </button>
                </div>
                <div class="filter-container">
                    <button class="promosAct">Activas</button>
                    <button class="promosInact">Inactivas</button>
                    <button class="promosTodas">Todo</button>
                </div>
                <div class="listaP">
                    <div class="promoCard">

                    </div>
                </div>   
                
            </div>

            <div class="vistaMovil">
                <div class="tituloM">
                    <h2>Vista previa</h2>
                </div>
                <div class="dispositivo">
                    <div class="mobile-content">
                        <div class="pill-indicator"></div>
                        <div class="status-bar">
                            <span>2:24</span>
                            <div class="status-icons">
                                <span>56%</span>
                            </div>
                        </div>
                        
                        
                        <div class="main-content">
                            
                            <div class="promo-card">
                                <div class="promo-header">
                                    <div class="promo-badge">2x1</div>
                                    <div class="promo-info">
                                        <h3>Promo Friends</h3>
                                        <p>Paga 700 por ti y tu bestfriend</p>
                                    </div>
                                </div>
                                
                                <div class="description">
                                    <h4>Descripción</h4>
                                    <p>Paga 700 por una mensualidad doble antes de la fecha establecida.</p>
                                </div>
                                
                                <div class="terms">
                                    <h4>Términos y Condiciones</h4>
                                    <p>Oferta válida hasta fin de mes. Incluye acceso a todas las áreas.</p>
                                </div>
                                
                                <div class="validity">
                                    <span class="clock-icon"></span>
                                    <span>Válido hasta: 30/5/2025</span>
                                </div>
                                
                                <div class="barcode-container">
                                    <div class="barcode" id="barcode"></div>
                                    <div class="barcode-number">#1071780a-3768-11f0-93d3-525400dc2c04</div>
                                </div>
                                
                                <button class="close-button">
                                    Cerrar promoción
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        


        <!-- Modal -->
        <div class="modal fade" id="agregarPromo" tabindex="-1" aria-labelledby="agregarPromo" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                
                    <div class="modal-header">
                        <h5 class="modal-title" id="promoModalLabel">Agregar Promoción</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form id="promoForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombrePromo" class="form-label">Nombre de la promoción</label>
                                    <input type="text" class="form-control" id="nombrePromo" placeholder="Ej. Promo Friends">
                                </div>
                                <div class="col-md-3">
                                    <label for="usuarioAsignado" class="form-label">Usuario</label>
                                    <select class="form-select" id="usuarioAsignado">
                                        <option value="">Seleccionar...</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="estado" class="form-label">Estado inicial</label>
                                    <select class="form-select" id="estado">
                                        <option value="0" selected>Inactiva</option>
                                        <option value="1">Activa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" placeholder="Ej. Paga 700 por ti y tu bestfriend">
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="oferta" class="form-label">Oferta</label>
                                    <input type="text" class="form-control" id="oferta" placeholder="Ej. 2x1">
                                </div>
                                <div class="col-md-4">
                                    <label for="categoria" class="form-label">Categoría</label>
                                    <input type="text" class="form-control" id="categoria" placeholder="Ej. Membresía">
                                </div>
                                <div class="col-md-4">
                                    <label for="fechaValidez" class="form-label">Válido hasta</label>
                                    <input type="date" class="form-control" id="fechaValidez">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="terminos" class="form-label">Términos y condiciones</label>
                                <textarea class="form-control" id="terminos" rows="2" placeholder="Ej. Oferta válida hasta fin de mes. Incluye acceso a todas las áreas."></textarea>
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="promoForm" class="btn btn-primary">Guardar</button>
                    </div>

                </div>
            </div>
        </div>


    </div>

    <script src="../asset/js/notificaciones.js"></script>
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/calendario.js"></script>
    <script src="../asset/js/codigoBarras.js"></script>
        <script src="../asset/js/funcionPromo.js"></script>


</body>
</html>