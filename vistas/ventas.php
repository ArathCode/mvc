<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../asset/css/iinventario.css">
        <title>Inventario DragonGym</title>
        <?php
            include_once("head.php");
        ?>
        
        <script src="asset/js/ventas.js?v=2.8"></script>
    </head>
    
    <body>

        <div class="container mx-auto p-3 w-100 w-md-75 w-lg-50" style="border: 5px solid red">
            <div class="row" style="border: 5px solid black">
                <h1>Ventas</h1>
                <div class="col" style="border: 5px solid black; min-height:750px; overflow-y:auto; overflow-x:hidden; max-height:790px">
                    <table class="table table-striped table-bordered table-hover text-center" id="ListaProductosventas">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Disponible</th>
                                <th>Tipo producto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contenido dinamico -->
                        </tbody>
                    </table>
                </div>

                <div class="col" style="border: 5px solid black">
                    <div class="row">
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
                    <div class="row">
                        <h2>Ventas del dia</h2>
                    
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>  