<!DOCTYPE html>
<html lang="es">

<head>
    <title>Miembros - DragonGym</title>
    <?php include_once("head.php"); ?>
    <script type="module" src="../asset/js/funcionesMiembros.js?v=2.0.6"></script>

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
                <div class="notificacion" onclick="toggleNotifi()">
                    <ion-icon name="file-tray-full-outline"></ion-icon>
                </div>
                <div class="usuario">
                    <img src="https://i.pinimg.com/originals/a0/14/7a/a0147adf0a983ab87e86626f774785cf.gif" alt="">
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
                                </div>
                                <div class="ama">
                                    <label for="ApellidoM" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="ApellidoM" name="ApellidoM">
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