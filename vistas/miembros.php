<!DOCTYPE html>
<html lang="es">

<head>
    <title>Miembros - DragonGym</title>
    <?php include_once("head.php"); ?>
    <script type="module" src="../asset/js/funcionesMiembros.js?v=1.0.3"></script>
    
    <link rel="stylesheet" href="../asset/css/gastos.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Miembros</h2>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
            Agregar Miembro
        </button>

        <!-- Modal AGREGAR -->
        <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarLabel">Agregar Miembro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarMiembro">
                            <div class="mb-3">
                                <label for="Nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="Nombre" name="Nombre" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ApellidoP" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" id="ApellidoP" name="ApellidoP" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ApellidoM" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" id="ApellidoM" name="ApellidoM">
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Sexo" class="form-label">Sexo</label>
                                <select class="form-control" id="Sexo" name="Sexo" required>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                                
                            </div>
                            <div class="mb-3">
                                <label for="Telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="Telefono" name="Telefono" maxlength="10"  required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
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
                        <h5 class="modal-title" id="modalEditarLabel">Editar Miembro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarMiembro">
                            <input type="hidden" id="ID_Miembro" name="ID_Miembro">
                            <div class="mb-3">
                                <label for="NombreEdit" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="NombreEdit" name="NombreEdit" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ApellidoPEdit" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" id="ApellidoPEdit" name="ApellidoPEdit" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ApellidoMEdit" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" id="ApellidoMEdit" name="ApellidoMEdit">
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="SexoEdit" class="form-label">Sexo</label>
                                <select class="form-control" id="SexoEdit" name="SexoEdit" required>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="TelefonoEdit" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="TelefonoEdit" name="TelefonoEdit" maxlength="10" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Miembros -->
        <div class="mt-5">
            <h4 class="text-center">Lista de Miembros</h4>
            <div class="row" id="ListaMiembros">
            </div>
            <div id="paginacion" class="mt-3"></div>
        </div>
        
        <a class="btn btn-info" href="index.php?pag=miembros">Miembros</a>
        <a class="btn btn-info" href="index.php?pag=admin">Usuarios</a>
        <a class="btn btn-info" href="index.php?pag=inventario">Inventario</a>
        <a class="btn btn-error" href="../salir.php">Cerrar Sesión</a>
    </div>
</body>

</html>
