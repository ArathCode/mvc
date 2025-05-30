<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuarios-DragonGym</title>
    <?php
    include_once("head.php");
    ?>
    <script type="module" src="asset/js/funcionesUsu.js?v=3.6.5"></script>
    <link rel="stylesheet" href="../asset/css/usuarios.css">
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
                <svg class="svg"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
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

        <div class="container mt-5">

            <div class="gB">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
                    Agregar Usuario
                </button>
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
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="Nombre" name="Nombre" maxlength="30" required>
                                        <div class="invalid-feedback"></div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ApellidoP" class="form-label">Apellido Paterno</label>
                                        <input type="text" class="form-control" id="ApellidoP" name="ApellidoP" maxlength="30" required>
                                        <div class="invalid-feedback"></div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ApellidoM" class="form-label">Apellido Materno</label>
                                        <input type="text" class="form-control" id="ApellidoM" name="ApellidoM" maxlength="30" required>
                                        <div class="invalid-feedback"></div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="CorreoUsu" class="form-label">Correo</label>
                                        <input type="email" class="form-control" id="CorreoUsu" name="CorreoUsu" maxlength="70" required>
                                        <span id="errorCorreoUsu"></span>
                                        <div class="invalid-feedback"></div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="NombreUsu" class="form-label">Usuario</label>
                                        <input type="text" class="form-control" id="NombreUsu" name="NombreUsu" maxlength="50" required>
                                        <span id="errorNombreUsu"></span>
                                        <div class="invalid-feedback"></div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Contra" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="Contra" name="Contra" maxlength="16" required>
                                        <div class="invalid-feedback"></div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Salario" class="form-label">Salario</label>
                                        <input type="number" class="form-control" id="Salario" name="Salario" min="0" max="1000000" placeholder="Ingrese un número" required>
                                        <div class="invalid-feedback"></div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="usutip" class="form-label">Tipo de Usuario</label>
                                        <select class="form-control" id="usutip" name="usutip">
                                            <option value="admin">Admin</option>
                                            <option value="coach">Coach</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
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
                                <input type="hidden" id="ID_Usuario" name="ID_Usuario">
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
                <h4 class="text-center">Lista de Usuarios</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="ListaUsuarios">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
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

        </div>


        <script src="../asset/js/main.js"></script>
</body>

</html>