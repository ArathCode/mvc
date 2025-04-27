<!DOCTYPE html>
<html lang="es">

<head>
    <title>Reportes-DragonGym</title>
    <?php
    include_once("head.php");
    ?>
   
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="../asset/js/estadisticas.js?v=1.4.9.3"></script>
   
    <script type="text/javascript">
    
        google.charts.load('current', {
            'packages': ['corechart' ]
        });

        google.charts.setOnLoadCallback(cargarMiembrosPorSexo);
        google.charts.setOnLoadCallback(cargarEstadoMembresias);
        google.charts.setOnLoadCallback(cargarGastosMensuales);
    </script>
   <link rel="stylesheet" href="../asset/css/usuarios.css">
   <link rel="stylesheet" href="../asset/css/Reportes.css">
    
</head>

<body class="bg-light">
    <div class="navigation">
        <?php
        include_once("encabezado.php")
        ?>
    </div>
    <div class="main">
        <div class="topbar">
        <div class="toggle">
                    <svg class="svg "xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </div>
            <div class="subMenu">
                <?php
                include_once("submenu.php")
                ?>
            </div>

            <div class="contenedor">
                <div class="notificacion" onclick="toggleNotifi()">
                    <svg class ="svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
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

        <div class="container">
                <div class="titulo">
                    <h2>
                        Reportes
                    </h2>
                </div>


                <div class="row" style="text-align:center">
                    <div class="col dropdown">
                        <a href="#"><img src="../asset/images/pdfRR.png" alt="" width="200px" height="200px"></a>
                        <div class="dropdown-content">
                            <a href="R_usu_pdf.php">Miembros PDF</a>
                            <a href="R_prod_pdf.php">Productos PDF</a>
                        </div>
                    </div>

                    <div class="col dropdown">
                        <a href="#"><img src="../asset/images/excel.png" alt="" width="200px" height="200px"></a>
                        <div class="dropdown-content">
                            <a href="R_usu_excel.php">Miembros Excel</a>
                            <a href="R_prod_excel.php">Productos Excel</a>
                        </div>
                    </div>

                    
                </div>
            </div>

            <div class="titulo">
                <h2>
                    Estadísticas
                </h2>
                <div class="graficosR" style="text-align:center;">
                <div class="gra12">
                    <div class="gra1">
                        <div id="chart_div2" ></div>
                    </div>
                    <div class="gra2">
                    <div id="chart_div" style="width: 600px; height: 400px;"></div>

                    </div>
                </div>
                <div class="gra3">
                    <div id="chart_div3" ></div>
                </div>
            </div>
            <table>
            <thead>
                <tr>
                    <th>Tipo de Usuario</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
                <tbody id="tbodySexo">

                </tbody>
            </table>
            <div id="chart_div2"></div>
            <div id="chart_div3"></div>
            </div>

        </div>
    </div>
   
    <script src="../asset/js/notificaciones.js"></script>
        <script src="../asset/js/main.js"></script>
        <script src="../asset/js/calendario.js"></script>

</body>

</html>