<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuarios-DragonGym</title>
    <?php
    include_once("head.php");
    ?>
    <script type="module" src="asset/js/funcionesMembresia.js?v=1.3"></script>
    
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center">Gestión de Membresias</h2>


        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
            Nueva Membresia
        </button>

        <!-- Modal AGREGAR -->
        <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarLabel">Agregar Membresia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregar">
                            <div class="mb-3">
                                <label for="Tipo" class="form-label">Tipo</label>
                                <input type="text" class="form-control" id="Tipo" name="Tipo" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Descripcion" class="form-label">Descripcion</label>
                                <input type="text" class="form-control" id="Descripcion" name="Descripcion" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                         
            
                            <div class="mb-3">
                                <label for="Costo" class="form-label">Costo</label>
                                <input type="number" class="form-control" id="Costo" name="Costo" min="0" max="1000000" placeholder="Ingrese un número" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar usuario -->
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarLabel">Editar Membresia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditar">
                            <input type="hidden" id="ID_Membresia" name="ID_Membresia">
                            <div class="mb-3">
                                <label for="TipoEdit" class="form-label">Tipo</label>
                                <input type="text" class="form-control" id="TipoEdit" name="TipoEdit" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="DescripcionEdit" class="form-label">Descripcion</label>
                                <input type="text" class="form-control" id="DescripcionEdit" name="DescripcionEdit" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                         
            
                            <div class="mb-3">
                                <label for="CostoEdit" class="form-label">Costo</label>
                                <input type="number" class="form-control" id="CostoEdit" name="CostoEdit" min="0" max="1000000" placeholder="Ingrese un número" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para cambiar contraseña -->
        <div class="modal fade" id="modalEditarClave" tabindex="-1" aria-labelledby="modalEditarClaveLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarClaveLabel">Cambiar Contraseña</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarClave">
                            <input type="hidden" id="ID_UsuarioClave" name="ID_Usuario">
                            
                            <div class="mb-3">
                                <label for="ClaveNueva" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="ClaveNueva" name="ClaveNueva" maxlength="16" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ConfirmarClave" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="ConfirmarClave" name="ConfirmarClave" maxlength="16" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
        <div class="mt-5">
            <h4 class="text-center">Lista de Usuarios</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="ListaUsuarios">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Descripcion</th>
                            <th>Costo</th>
                            
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <a class="btn btn-info" href="index.php?pag=gastos">Gastos</a>
        <a class="btn btn-info" href="index.php?pag=usuarios">Usuarios</a>
        <a class="btn btn-info" href="index.php?pag=membresias">Miembros</a>
        <a class="btn btn-error" href="../salir.php">Cerrar Sesión</a>
    </div>
    


</body>

</html>