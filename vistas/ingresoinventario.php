<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../asset/css/iinventario.css">
        <title>Inventario DragonGym</title>
        <?php
            include_once("head.php");
        ?>
        
        <script src="asset/js/inventario.js?v=2.6"></script>
    </head>

    <body>

        <div class="container mx-auto p-3 w-100 w-md-75 w-lg-50" style="border: 5px solid red">
            <div class="row" style="border: 5px solid black">
                <h1>Inventario</h1>
                <div aria-label="Basic outlined example" class="botonesa" id="botonesa">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">Nuevo producto</button>
                </div>
                <div class="col" style="min-height:750px; overflow-y:auto; overflow-x:hidden; max-height:790px">
                    <table class="table table-striped table-bordered table-hover text-center" id="ListaProductos">
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
                            <button type="submit" class="btn btn-primary">Guardar</button>
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
                            <button type="submit" class="btn btn-primary">Guardar</button>
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
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>

