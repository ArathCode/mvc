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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
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




        <div class="container mt-3">
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
            <div class="mt-3">
                <div class="table-responsive" id="ListaGastos">

                </div>
                <div id="paginacion" class="mt-3"></div>
            </div>

            
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
    <script src="../asset/js/notificaciones.js"></script>
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/calendario.js"></script>
</body>

</html>