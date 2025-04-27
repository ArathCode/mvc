<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../asset/css/inventario.css">
        <title>Inventario DragonGym</title>
        <?php
            include_once("head.php");
        ?>
        
        <script src="asset/js/inventario.js?v=2.6"></script>
    </head>

    <body>

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

            <div class="gB" id="botonesa">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">Nuevo producto</button>
            </div>
            <div class="tablaI">
                <table class="table table-striped" id="ListaProductos">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Disponible</th>
                            <th>Tipo producto</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contenido dinamico -->
                    </tbody>
                </table>
            </div>


        </div>

        <!-- Modal AGREGAR -->
        <div class="modal fade" id="modalAgregarProducto" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarLabel">Agregar nuevo producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarProducto" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="img" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="img" name="img" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="Descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="Descripcion" name="Descripcion" maxlength="50" required>
                            </div>
                            <div class="mb-3">
                                <label for="Precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="Precio" name="Precio" required>
                            </div>

                            <div class="mb-3">
                                <label for="ID_TipoProducto" class="form-label">Tipo de Producto</label>
                                <select class="form-control" id="ID_TipoProducto" name="ID_TipoProducto" required>
                                    <option value="">Seleccione un tipo</option>
                                    <!-- Opciones cargadas dinámicamente -->
                                </select>
                            </div>
                            <button type="submit" id="btnP" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal EDITAR -->
        <div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarLabel">Editar producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarProducto" >
                            <input type="hidden" id="ID_Producto" name="ID_Producto">
                          
                            <div class="mb-3">
                                <label for="img" class="form-label">Imagen</label>
                                <input type="text" id="imge" name="imge">
                            </div>
                            <div class="mb-3">
                                <label for="Descripcion" class="form-label">Descripción</label>
                                <input type="text" id="Descripcione" name="Descripcione">
                            </div>
                            <div class="mb-3">
                                <label for="Precio" class="form-label">Precio</label>
                                <input type="number" id="precioe" name="precioe">
                            </div>

                            <div class="mb-3">
                                <label for="ID_TipoProductoe" class="form-label">Tipo de Producto</label>
                                <input type="number" id="ID_TipoProductoe" name="ID_TipoProductoe">
                                <!--  <select class="form-control" id="ID_TipoProductoe" name="ID_TipoProductoe" required>
                                    <option value="">Seleccione un tipo</option>
                                    Opciones cargadas dinámicamente -->
                                </select>
                            </div>
                            <button type="submit" id="btnP" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal AGREGAR CANTIDAD -->
        <div class="modal fade" id="modalAgregarCantidad" tabindex="-1" aria-labelledby="modalAgregarCantidadLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarCantidadLabel">Agregar Cantidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarCantidad">
                            <div class="mb-3">
                                <label for="productoDescripcion" class="form-label">Producto</label>
                                <input type="text" class="form-control" id="productoDescripcion" name="productoDescripcion" readonly>
                                <input type="hidden" id="productoIdCantidad" name="ID_Producto">

                            </div>

                            <div class="mb-3">
                                <label for="Cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="Cantidad" name="Cantidad" required>
                            </div>
                            <div class="mb-3">
                                <label for="Fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="Fecha" name="Fecha" required>
                            </div>
                            <button type="submit" id="btnP" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="../asset/js/notificaciones.js"></script>
        <script src="../asset/js/main.js"></script>
        <script src="../asset/js/calendario.js"></script>
    </body>
</html>

