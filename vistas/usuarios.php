<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuarios-DragonGym</title>
    <?php
    include_once("head.php");
    ?>
    <script type="module" src="asset/js/funcionesUsu.js?v=3.5"></script>
    
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center">Gestión de Usuarios</h2>


        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
            Agregar Usuario
        </button>

        <!-- Modal AGREGAR -->
        <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarLabel">Agregar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregar">
                            <div class="mb-3">
                                <label for="Nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="Nombre" name="Nombre" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ApellidoP" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" id="ApellidoP" name="ApellidoP" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ApellidoM" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" id="ApellidoM" name="ApellidoM" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="CorreoUsu" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="CorreoUsu" name="CorreoUsu" maxlength="70" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="NombreUsu" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="NombreUsu" name="NombreUsu" maxlength="50" required>
                            </div>
                            <div class="mb-3">
                                <label for="Contra" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="Contra" name="Contra" maxlength="16" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Salario" class="form-label">Salario</label>
                                <input type="number" class="form-control" id="Salario" name="Salario" min="0" max="1000000" placeholder="Ingrese un número" required>
                            </div>
                            <div class="mb-3">
                                <label for="usutip" class="form-label">Tipo de Usuario</label>
                                <select class="form-control" id="usutip" name="usutip">
                                    <option value="admin">Admin</option>
                                    <option value="coach">Coach</option>
                                </select>
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
                        <h5 class="modal-title" id="modalEditarLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditar">
                            <input type="hidden" id="ID_Usuario" name="ID_Usuario">
                            <div class="mb-3">
                                <label for="NombreEdit" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="NombreEdit" name="NombreEdit" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ApellidoPEdit" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" id="ApellidoPEdit" name="ApellidoPEdit" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ApellidoMEdit" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" id="ApellidoMEdit" name="ApellidoMEdit" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="CorreoUsuEdit" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="CorreoUsuEdit" name="CorreoUsuEdit" maxlength="70" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="NombreUsuEdit" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="NombreUsuEdit" name="NombreUsuEdit" maxlength="50" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="SalarioEdit" class="form-label">Salario</label>
                                <input type="number" class="form-control" id="SalarioEdit" name="SalarioEdit" min="0" max="1000000" placeholder="Ingrese un número" required>
                            </div>
                            <div class="mb-3">
                                <label for="usutipEdit" class="form-label">Tipo de Usuario</label>
                                <select class="form-control" id="usutipEdit" name="usutipEdit">
                                    <option value="admin">Admin</option>
                                    <option value="coach">Coach</option>
                                </select>
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
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Usuario</th>
                            
                            <th>Salario</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <a class="btn btn-info" href="salir.php">Cerrar Sesión</a>
        <a href="index.php?pag=gastos">Ir a otra página</a>
    </div>
    


</body>

</html>