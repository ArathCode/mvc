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
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <div class="adminUsuarios" >
                <a href="index.php?pag=miembros">
                    <ion-icon name="people-outline"></ion-icon>
                    <span>Miembros</span>
                </a>
            </div>
            <div class="adminMemb" >
                <a href="index.php?pag=relacion">
                    <ion-icon name="card-outline"></ion-icon>
                    <span>Membresías</span>
                </a>
            </div>
            <div class="contenedor">
                <div class="usuario">
                    <img src="https://i.pinimg.com/originals/a0/14/7a/a0147adf0a983ab87e86626f774785cf.gif" alt="">
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

</body>

</html>