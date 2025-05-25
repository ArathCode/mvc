<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../asset/css/ventas.css">
        <title>Inventario DragonGym</title>
        <?php
            include_once("head.php");
        ?>
        
        <script src="asset/js/ventas.js?v=2.8.2"></script>
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

            <div class="container mx-auto p-3 w-100 w-md-75 w-lg-50" >
            <div class="row" >
                <h1>Ventas</h1>
                <div class="col" style=" min-height:750px; overflow-y:auto; overflow-x:hidden; max-height:790px">

                    <!-- Filtros -->
                    <div aria-label="Filtros" class="container my-3">
  <div class="card p-3 shadow-sm">
    <div class="row g-3 align-items-end">
      
      <div class="col-md-4">
        <label for="filtroNombreVenta" class="form-label">Nombre:</label>
        <input type="text" class="form-control" id="filtroNombreVenta" placeholder="Buscar por nombre">
      </div>

      <div class="col-md-4">
        <label for="filtroDisponibleVenta" class="form-label">Disponibilidad:</label>
        <select id="filtroDisponibleVenta" class="form-select">
          <option value="">-- Seleccione --</option>
          <option value="disponible">Disponible</option>
          <option value="nodisponible">No disponible</option>
        </select>
      </div>

      <div class="col-md-4">
        <label for="filtroTipoVenta" class="form-label">Tipo de Producto:</label>
        <select id="filtroTipoVenta" class="form-select">
          <option value="">-- Seleccione un tipo --</option>
        </select>
      </div>

      <div class="col-12 text-end">
        <button type="button" id="resetFiltrosVenta" class="btn btn-secondary">Resetear filtros</button>
      </div>
      
    </div>
  </div>
</div>


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

                <div class="col" style=" min-height:750px; overflow-y:auto; overflow-x:hidden; max-height:790px">
                    <div class="row" style=" min-height:260px; overflow-y:auto; overflow-x:hidden; max-height:300px">
                        <h2>Carrito</h2>
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

                        <div>
                            <div class="gB">
                            <button id="btnConfirmarVenta" type="button"  class="btn btn-success">Confirmar Venta</button>
                            </div>
                            <input type="hidden" name="ID_UsuarioVenta" id="ID_UsuarioVenta" value="<?php echo $_SESSION['ID_Usuario']; ?>">
                        </div>
                        
                    </div>
                    <div class="row" style="min-height:430px; overflow-y:auto; overflow-x:hidden; max-height:480px">
                        <h2>Ventas del día</h2>
                        <table class="table table-striped table-bordered table-hover text-center" id="VentasDelDia">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Contenido dinámico -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            
        </div>


    <script src="../asset/js/notificaciones.js"></script>
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/calendario.js"></script>

    </body>
</html>  