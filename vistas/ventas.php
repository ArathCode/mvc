<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../asset/css/ventas.css">
        <title>Inventario DragonGym</title>
        <?php
            include_once("head.php");
        ?>
        
        <script src="asset/js/ventas.js?v=2.8"></script>
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

            <h2>Ventas</h2>
            <div class="divisionC">
                <div class="izq">
                    <div  id="ListaProductosventas"> 
                    </div>
                    


                    <div class="row">
                        <h2>Ventas del dia</h2>
                    </div>
                </div>
                <div class="der">
                    <div >
                        <h2>Hacer venta</h2>
                        <table id="tablaVenta" class="table">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                        <button id="btnConfirmarVenta" class="btn btn-success">Confirmar Venta</button>

                    </div>
                </div>
            </div>
            
        </div>


    <script src="../asset/js/notificaciones.js"></script>
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/calendario.js"></script>

    </body>
</html>  