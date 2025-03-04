<?php 
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Si la sesión NO está iniciada, ir al login
    if (!isset($_SESSION["sistema"]) || $_SESSION["sistema"] !== "DragonGym") {
        include_once("vistas/login copy.php");
        exit(); 
    }

    
    $tipoUsuario = $_SESSION["tipo"];

    if(isset($_GET["pag"])) {
        $pag = $_GET["pag"];

      
        if($pag == "admin" && $tipoUsuario == "admin") {
            include_once("vistas/usuarios.php");
        }
        
        elseif($pag == "gastos" && $tipoUsuario == "admin") {
            include_once("vistas/Gastos.php");
        }
        
        elseif($pag == "user" && $tipoUsuario == "general") {
            include_once("vistas/usuario.php");
        }
        else {
            echo "<h2>Acceso denegado. Verifique su usuario.</h2>";
            exit();
        }
    } else {
        
        if ($tipoUsuario == "admin") {
            header("Location: index.php?pag=admin");
        } elseif ($tipoUsuario == "gestor") {
            header("Location: index.php?pag=gestor");
        } elseif ($tipoUsuario == "general") {
            header("Location: index.php?pag=user");
        } else {
            session_unset();
            session_destroy();
            include_once("vistas/login copy.php");
            exit();
        }
    }
?>
