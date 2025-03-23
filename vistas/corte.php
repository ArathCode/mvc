<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corte de Caja - Dragon's Gym</title>
    <?php include_once("head.php"); ?>
    <script type="module" src="../asset/js/corte.js?v=4.9.3"></script>
    <link rel="stylesheet" href="../asset/css/corte.css">
    
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
                <ion-icon name="menu-outline"></ion-icon>
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
        <h2>Corte de Caja - Dragon's Gym</h2>
        <div class="centrar">
            <div class="contenedorC">
                <div class="ContenedorF">
                    <img src="../asset/images/logo.jpg" alt="Logo Dragon Gym">
                    <h2 id="MesAct">Marzo 2025</h2>
                    <p id="DiaAct">Domingo 23</p>
                    <p id="horaAct">09:44 am</p>
                </div>
                <div class="corteB">
                    <div class="botones">
                        <button id="btnCorte">
                            <img id="notepadImg" src="../asset/images/notepadO.png" alt="">
                        </button>
                        <button id="btnCortePdf">
                            <img id="pdfImg" src="../asset/images/pdfO.png" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    

    <script src="../asset/js/calendario.js"></script>
    <script src="../asset/js/notificaciones.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


</body>
</html>
