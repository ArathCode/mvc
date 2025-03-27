<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuarios-DragonGym</title>
    <?php
    include_once("head.php");
    ?>
    
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
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <div class="subMenu">
                <?php
                include_once("submenu.php")
                ?>
            </div>

            <div class="contenedor">
                <div class="usuario">
                    <img src="https://i.pinimg.com/originals/a0/14/7a/a0147adf0a983ab87e86626f774785cf.gif" alt="">
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
            </div>

            <div class="graficosR" style="text-align:center;">
                <div class="gra12">
                    <div class="gra1">
                        <div id="chart_div2" ></div>
                    </div>
                    <div class="gra2">
                        <div id="chart_div" ></div>
                    </div>
                </div>
                <div class="gra3">
                    <div id="chart_div3" ></div>
                </div>
            </div>

        </div>
    </div>


        <script src="../asset/js/main.js"></script>
</body>

</html>