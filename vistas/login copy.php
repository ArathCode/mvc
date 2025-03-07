<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dragon Gym</title>
    <link rel="stylesheet" href="asset/css/login.css">
    <?php
    include_once("head.php");
    ?>
    <script type="module" src="asset/js/funciones.js?v=2.4"></script>
</head>

<body>
    <div class="container">
        <div class="left-section">
            <div class="content">
                <img src="asset/images/logo.jpg" alt="Logo" class="logo">
            </div>
        </div>
        <div class="right-section">
            <h2>Hola, Bienvenido</h2>
            <p>Sistema Dragon' Gym</p>
            <form method="POST" id="login">
                <div>
                    <?php echo isset($alert) ? $alert : ""; ?>
                </div>
                <div class="input-group">
                    <input type="text" id="nombre" name="nombre"  minlength="5" maxlength="10" pattern=".{5,10}" required>
                    <label for="nombre">Usuario</label>
                    <div class="invalid-feedback">
                        Email is invalid
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="input-group">
                    <input type="password" id="contra" name="contra" required>
                    <label for="contra">Contraseña</label>
                    <div class="invalid-feedback">
                        Password is required
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <a href="views/recuperacion.php">¿Olvidó la contraseña?</a>
                <button type="submit" class="login">
                    <span>Ingresar</span>
                </button>
            </form>
        </div>
    </div>
</body>

</html>