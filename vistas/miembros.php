<!DOCTYPE html>
<html lang="es">

<head>
    <title>Miembros - DragonGym</title>
    <?php include_once("head.php"); ?>
    <script type="module" src="../asset/js/funcionesMiembros.js?v=2.0.9"></script>

    <link rel="stylesheet" href="../asset/css/miembros.css">
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
            <div class="adminUsuarios" >
                <a href="index.php?pag=miembros">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    <span>Miembros</span>
                </a>
            </div>
            <div class="adminMemb" >
                <a href="index.php?pag=relacion">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                    <span>Membresías</span>
                </a>
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

        
        <div class="gB">
            
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
                Agregar Miembro
            </button>

            

        </div>

        <div class="filter-container">
            <div class="filter" data-filter="id">
                <span>ID</span><input type="number" id="idM" class="hidden" placeholder="Escribe aquí.."> <button class="close"></button> <button class="close">✖</button>
            </div>
            <div class="filter" data-filter="nombre">
                <span>Nombre</span> <input type="text" id="nombreM" class="hidden" placeholder="Escribe aquí.."> <button class="close"></button> <button class="close">✖</button>
            </div>
            <div class="filter" data-filter="nombre">
                <span>Apellidos </span> <input type="text" id="apeP" placeholder="Escribe aquí.." class="hidden"> <button class="close">✖</button>
            </div>
            <div class="filter" data-filter="numero">
                <span>Télefono</span> <input type="text" id="numM" class="hidden" placeholder="Escribe aquí.."> <button class="close"></button> <button class="close">✖</button>
            </div>
            <div class="filter-miembros">
                <button id="limpiarM" class="btn btn-secondary">Limpiar Filtros</button>
            </div>
        </div>

        <!-- Tabla de Miembros -->
        <div class="mt-3">
            <h4 class="text-center">Lista de Miembros</h4>
            <div class="row" id="ListaMiembros">
            </div>
            <div id="paginacion" class="mt-3"></div>
        </div>

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
                            <div class="apellidos">
                                <div class="apa">
                                    <label for="ApellidoP" class="form-label">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="ApellidoP" name="ApellidoP" required>
                                    <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                </div>
                                <div class="ama">
                                    <label for="ApellidoM" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="ApellidoM" name="ApellidoM">
                                    <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
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
                                <input type="text" class="form-control" id="Telefono" name="Telefono" maxlength="10" required>
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
                            <div class="apellidos">
                                <div class="apa">
                                    <label for="ApellidoPEdit" class="form-label">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="ApellidoPEdit" name="ApellidoPEdit" required>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="ama">
                                    <label for="ApellidoMEdit" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="ApellidoMEdit" name="ApellidoMEdit">
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
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
                            <div class="mb-3">
                                <label for="pinEdit" class="form-label">PIN</label>
                                <input type="text" class="form-control" id="pinEdit" name="pinEdit" maxlength="4" required>
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




    </div>
    <script src="../asset/js/notificaciones.js"></script>
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/calendario.js"></script>
    
</body>

</html>