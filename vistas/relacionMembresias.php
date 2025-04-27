<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuarios-DragonGym</title>
    <?php
    include_once("head.php");
    ?>
    <script type="module" src="asset/js/funcionesRelacionM.js?v=1.9.7"></script>
    
</head>

<body >

<!-- =============== Barra de navegacion ================ -->
    <div class="navigation">
        <?php
        include_once("encabezado.php")
        ?>
        <link rel="stylesheet" href="../asset/css/relacionM.css">
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

        <h2 class="text-center">Relacion de membresias</h2>
            
        <div class="gB">
            <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#modalAgregar">
                Asignar Membresia
            </button>
        </div>
        
        <div class="filter-container">
            <div>
                <button class="btn btn-success filter-button">Vigentes</button>
                <button class="btn btn-danger filter-button">Vencidas</button>
                <button class="btn btn-warning filter-button">Proximas a vencer</button>
                <button class="btn btn-secondary filter-button">Todas</button>
            </div>
        </div>


        <!-- Modal AGREGAR -->
        <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarLabel">Asignar membresia</h5>
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

      
        <!-- Tabla de Usuarios -->
        <div class="mt-3" id="relT">
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
                
            </div>
            <div id="paginacion" class="mt-3"></div>
        </div>
            
    </div>

    <script src="../asset/js/notificaciones.js"></script>
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/calendario.js"></script>
</body>

</html>