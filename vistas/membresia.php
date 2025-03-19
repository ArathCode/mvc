<!DOCTYPE html>
<html lang="es">

<head>
    <title>Usuarios-DragonGym</title>
    <?php
    include_once("head.php");
    ?>
    <script type="module" src="asset/js/funcionesMembresia.js?v=1.8"></script>
    <link rel="stylesheet" href="../asset/css/membresias.css">
</head>

<body >

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
                        <a href="index.php?pag=gastos">Gastos</a>
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
                        <a href="index.php?pag=usuarios">Usuarios</a>
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


        <h2 class="text-center">Gestión de Membresias</h2>


        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
            Nueva Membresia
        </button>

        <!-- Modal AGREGAR -->
        <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarLabel">Agregar Membresia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregar">
                            <div class="mb-3">
                                <label for="Tipo" class="form-label">Tipo</label>
                                <input type="text" class="form-control" id="Tipo" name="Tipo" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Descripcion" class="form-label">Descripcion</label>
                                <input type="text" class="form-control" id="Descripcion" name="Descripcion" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                         
            
                            <div class="mb-3">
                                <label for="Costo" class="form-label">Costo</label>
                                <input type="number" class="form-control" id="Costo" name="Costo" min="0" max="1000000" placeholder="Ingrese un número" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar usuario -->
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarLabel">Editar Membresia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditar">
                            <input type="hidden" id="ID_Membresia" name="ID_Membresia">
                            <div class="mb-3">
                                <label for="TipoEdit" class="form-label">Tipo</label>
                                <input type="text" class="form-control" id="TipoEdit" name="TipoEdit" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="DescripcionEdit" class="form-label">Descripcion</label>
                                <input type="text" class="form-control" id="DescripcionEdit" name="DescripcionEdit" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                         
            
                            <div class="mb-3">
                                <label for="CostoEdit" class="form-label">Costo</label>
                                <input type="number" class="form-control" id="CostoEdit" name="CostoEdit" min="0" max="1000000" placeholder="Ingrese un número" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- Tabla de Usuarios -->
        <div class="mt-5">
                <h4 class="text-center">Lista de Gastos</h4>
                <div class="row" id="ListaMembresias"></div>  
        </div>

    </div>

</body>

</html>