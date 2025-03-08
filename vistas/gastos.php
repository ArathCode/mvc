<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuarios-DragonGym</title>
    <?php include_once("head.php"); ?>
    <script type="module" src="../asset/js/funcionesGasto.js?v=4.9.3"></script>
    
    <link rel="stylesheet" href="../asset/css/gastostarjetas.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Gastos</h2>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
            Agregar Gasto
        </button>
        <div class="filtro-fecha">
        <label for="fechaInicio">Desde:</label>
        <input type="date" id="fechaInicio">
        
        <label for="fechaFin">Hasta:</label>
        <input type="date" id="fechaFin">
        
        <button id="btnListar">Filtrar</button>
    </div>

        <!-- Modal AGREGAR -->
        <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarLabel">Agregar Gasto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarGasto">
                            <div class="mb-3">
                                <label for="Descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="Descripcion" name="Descripcion" maxlength="200" required>
                            </div>
                            <div class="mb-3">
                                <label for="Fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="Fecha" name="Fecha" required>
                            </div>
                            <div class="mb-3">
                                <label for="Precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="Precio" name="Precio" min="0" max="1000000" required>
                            </div>
                            <input type="hidden" name="ID_Usuario" id="ID_Usuario" value="<?php echo $_SESSION['ID_Usuario']; ?>">

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
                        <h5 class="modal-title" id="modalEditarLabel">Editar Gasto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarGasto">
                            <input type="hidden" id="ID_Gasto" name="ID_Gasto">
                            <div class="mb-3">
                                <label for="DescripcionEdit" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="DescripcionEdit" name="DescripcionEdit" maxlength="200" required>
                            </div>
                            <div class="mb-3">
                                <label for="FechaEdit" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="FechaEdit" name="FechaEdit" required>
                            </div>
                            <div class="mb-3">
                                <label for="PrecioEdit" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="PrecioEdit" name="PrecioEdit" min="0" max="1000000" required>
                            </div>
                            <input type="hidden" name="ID_UsuarioEdit" id="ID_UsuarioEdit" value="<?php echo $_SESSION['ID_Usuario']; ?>">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Gastos -->
        <div class="mt-5">
            <h4 class="text-center">Lista de Gastos</h4>
            <div class="table-responsive" id="ListaGastos">
            
            </div>
            <div id="paginacion" class="mt-3"></div>
        </div>
        
        <a class="btn btn-info" href="index.php?pag=gastos">Gastos</a>
        <a class="btn btn-info" href="index.php?pag=admin">Usuarios</a>
        <a class="btn btn-error" href="../salir.php">Cerrar Sesión</a>

    </div>
</body>

</html>