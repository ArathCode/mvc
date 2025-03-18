<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuarios-DragonGym</title>
    <?php
    include_once("head.php");
    ?>
    <script type="module" src="asset/js/funcionesRelacionM.js?v=1.9.4"></script>

</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center">Relacion de membresias</h2>


        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalAgregar">
            Agregar Usuario
        </button>
        <div class="d-flex justify-content-between mb-3">
    <div>
        <button class="btn btn-success" >Vigentes</button>
        <button class="btn btn-danger" >Vencidas</button>
        <button class="btn btn-warning" >Proximas a vencer</button>
        <button class="btn btn-secondary" >Todas</button>
    </div>
</div>
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
                            <div class="mb-3 d-flex align-items-center">
                                <div class="me-3 flex-grow-1">
                                    <label for="ID_Miembro" class="form-label">ID Miembro</label>
                                    <input type="number" class="form-control" id="ID_Miembro" name="ID_Miembro" placeholder="Escriba el ID" required>
                                </div>
                                <div class="flex-grow-2">
                                    <label for="nombreMiembro" class="form-label">Nombre del Miembro</label>
                                    <input type="text" class="form-control" id="nombreMiembro" placeholder="Nombre" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ID_Membresia" class="form-label">Tipo de Membresía</label>
                                <select class="form-control" id="ID_Membresia" name="ID_Membresia" required>
                                    <!-- Las opciones se llenarán dinámicamente con JS -->
                                </select>
                            </div>

                            
                                <input type="hidden" name="ID_Usuario" id="ID_Usuario" value="<?php echo $_SESSION['ID_Usuario']; ?>">
                        

                            <div class="mb-3">
                                <label for="FechaInicio" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" id="FechaInicio" name="FechaInicio" required>
                            </div>

                            <div class="mb-3">
                                <label for="FechaFin" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" id="FechaFin" name="FechaFin" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="Costo" class="form-label">Costo</label>
                                <input type="number" class="form-control" id="Costo" name="Costo" min="1"  readonly>
                            </div>

                            <div class="mb-3">
                                <label for="Cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="Cantidad" name="Cantidad" min="1" value="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="FechaPago" class="form-label">Fecha de Pago</label>
                                <input type="date" class="form-control" id="FechaPago" name="FechaPago" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal EDITAR -->
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditar">
                            <input type="hidden" id="ID_MiemMem" name="ID_MiemMem">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="NombreEdit" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="NombreEdit" name="NombreEdit" maxlength="30" required>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="ApellidoPEdit" class="form-label">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="ApellidoPEdit" name="ApellidoPEdit" maxlength="30" required>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="ApellidoMEdit" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="ApellidoMEdit" name="ApellidoMEdit" maxlength="30" required>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="CorreoUsuEdit" class="form-label">Correo</label>
                                    <input type="email" class="form-control" id="CorreoUsuEdit" name="CorreoUsuEdit" maxlength="70" required>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="NombreUsuEdit" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="NombreUsuEdit" name="NombreUsuEdit" maxlength="50" required>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="SalarioEdit" class="form-label">Salario</label>
                                    <input type="number" class="form-control" id="SalarioEdit" name="SalarioEdit" min="0" max="1000000" placeholder="Ingrese un número" required>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="usutipEdit" class="form-label">Tipo de Usuario</label>
                                    <select class="form-control" id="usutipEdit" name="usutipEdit">
                                        <option value="admin">Admin</option>
                                        <option value="coach">Coach</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
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
            <h4 class="text-center">Membresias Asignadas</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="ListaUsuarios">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo Membresia</th>
                            <th>Usuario Asignado</th>
                            <th>Fecha Inicio</th>

                            <th>Fecha FIn</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Fecha Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div id="paginacion" class="mt-3"></div>
            </div>
        </div>
        <a class="btn btn-info" href="index.php?pag=gastos">Gastos</a>
        <a class="btn btn-info" href="index.php?pag=usuarios">Usuarios</a>
        <a class="btn btn-info" href="index.php?pag=membresias">Miembros</a>
        <a class="btn btn-error" href="../salir.php">Cerrar Sesión</a>
    </div>



</body>

</html>