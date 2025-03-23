<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/css/recuperacion.css">
    <title>Recuperación</title>
</head>
<body>
    <div class="encabezado">
        <div class="imagen">
            <img src="../asset/images/logo.jpg" alt="Logo" class="logo">
        </div>
    </div>

    <div class="main">
        <div class="titulo">
            <h2>Recuperación de contraseña</h2>
        </div>
        
        <div class="formulario">
            <form id="formRecuperacion">
                <div id="alerta"></div> <!-- Mensajes dinámicos -->

                <div class="contenidoIn">
                    <div class="input-group">
                        <input type="email" id="correo" name="correo" required>
                        <label for="correo">Correo electrónico</label>
                    </div>
                </div>
                <div class="boton">
                    <button type="submit" class="pushable">
                        <span class="shadow"></span>
                        <span class="edge"></span>
                        <span class="front">Enviar correo</span>
                    </button>
                </div>
                <div class="regresar">
                    <a href="../index.php" class="btn btn-danger">Regresar</a>
                </div>
            </form>  
        </div>
    </div>

    <!-- Enlace al JavaScript -->
    <script src="../asset/js/recuperacion.js?v=3.1"></script>
</body>
</html>
