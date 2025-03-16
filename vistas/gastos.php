<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuarios-DragonGym</title>
    <?php include_once("head.php"); ?>
    <script type="module" src="../asset/js/funcionesGasto.js?v=4.9.3"></script>

    <link rel="stylesheet" href="../asset/css/gastos.css">
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
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <div class="subMenu">
                <div class="gastos">
                    <div class="iconoGa">
                        <ion-icon name="wallet-outline"></ion-icon>
                    </div>
                    <div class="enlace">
                        <a href="Gastos.php">Gastos</a>
                    </div>
                </div>
                <div class="inventario">
                    <div class="iconoIn">
                        <ion-icon name="archive-outline"></ion-icon>
                    </div>
                    <div class="enlace">
                        <a href="inventario.php">Inventario</a>
                    </div>
                </div>
                <div class="adminUsuarios">
                    <div class="iconoAd">
                        <ion-icon name="people-outline"></ion-icon>
                    </div>
                    <div class="enlace">
                        <a href="ControlPersonal.php">Usuarios</a>
                    </div>
                </div>
                <div class="reportes">
                    <div class="iconoRe">
                        <ion-icon name="document-attach-outline"></ion-icon>
                    </div>
                    <div class="enlace">
                        <a href="Reportes.php">Reportes</a>
                    </div>
                </div>
            </div>

            <div class="contenedor">
                <div class="usuario">
                    <img src="https://i.pinimg.com/originals/a0/14/7a/a0147adf0a983ab87e86626f774785cf.gif" alt="">
                </div>
            </div>
        </div>




        <div class="container mt-5">
            <div class="gB">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
                    Agregar Gasto
                </button>
            </div>

            <div class="filter-container">
                <div class="filter" data-filter="hoy">
                    <span>Hoy</span> <button class="close">✖</button>
                </div>
                <div class="filter" data-filter="semana">
                    <span>Semana</span> <button class="close">✖</button>
                </div>
                <div class="filter" data-filter="dia">
                    <span>Día</span> <input type="date" id="fecha" class="hidden"> <button class="close">✖</button>
                </div>
                <div class="filter" data-filter="mes">
                    <span>Mes</span>
                    <select id="mes" class="hidden">
                        <option>Enero</option>
                        <option>Febrero</option>
                        <option>Marzo</option>
                        <option>Abril</option>
                        <option>Mayo</option>
                        <option>Junio</option>
                        <option>Julio</option>
                        <option>Agosto</option>
                        <option>Septiembre</option>
                        <option>Octubre</option>
                        <option>Noviembre</option>
                        <option>Diciembre</option>
                    </select>
                    <button class="close">✖</button>
                </div>
                <div class="filter" data-filter="año">
                    <span>Año</span>
                    <select id="año" class="hidden"></select>
                    <button class="close">✖</button>
                </div>

                <div class="filter filter-fechas" data-filter="rango-fechas">
                    <span>Desde</span>
                    <input type="date" id="fechaInicio" class="hidden">
                    <input type="date" id="fechaFin" class="hidden">
                    <button id="btnFiltrar" class="hidden">Filtrar</button>
                    <button class="close">✖</button>
                </div>
                <div class="filter-fechas">
                    <button id="limpiarG" class="btn btn-secondary">Limpiar Filtros</button>
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
            <a class="btn btn-info" href="index.php?pag=usuarios">Usuarios</a>
            <a class="btn btn-info" href="index.php?pag=membresias">mebresias</a>
            <a class="btn btn-info" href="index.php?pag=miembros">Miembros</a>

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
                                <textarea class="form-control" id="Descripcion" name="Descripcion" maxlength="200" rows="4" required></textarea>
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
                                <textarea class="form-control" id="DescripcionEdit" name="DescripcionEdit" maxlength="200" rows="4" required></textarea>
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

    </div>

</body>

</html>