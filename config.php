<?php
    define("RUTA","/mvc/");
    date_default_timezone_set('America/Mexico_City');

    function dbConectar()
    {
        static $conexion;

        if(!isset($connection)) 
        {
            $config = parse_ini_file('config.ini'); 
            $conexion = mysqli_connect($config['servidor'],$config['usuario'],$config['pass'],$config['bbdd']);
            $query="set CHARSET 'utf8'";
			$conexion->query($query);
        }
        if($conexion === false) 
        {
            // Manejo de error - notificamos al administrador, creamos un archivo log, mostramos un error en pantalla, etc.
            return mysqli_connect_error(); 
        }
        return $conexion;

    }

?>
