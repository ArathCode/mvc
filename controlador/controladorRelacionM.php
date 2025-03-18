<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/ModeloRelacionM.php");
    $usu = new Usuarios();

    // Operación de Login
    if ($ope == "LOGIN" && isset($_POST["nombre"], $_POST["contra"])) {
        $correo = $_POST["nombre"];
        $pass = $_POST["contra"];

        $status = $usu->Login($correo, $pass);
        if ($status[0]) {
            $info = array(
                "success" => true,
                "ruta" => RUTA . "/?pag=" . $status[1]
            );
        } else {
            $info = array(
                "success" => false,
                "msg" => "El usuario o contraseña proporcionados son incorrectos."
            );
        }
        echo json_encode($info);
    }
    // listar 
    elseif ($ope == "LISTAUSUARIOS") {
        $pagina = isset($_POST["pagina"]) ? intval($_POST["pagina"]) : 1;
            $registrosPorPagina = isset($_POST["registrosPorPagina"]) ? intval($_POST["registrosPorPagina"]) : 10;
        $lista = $usu->ListarTODOS($pagina, $registrosPorPagina); // Llamamos a la nueva función del modelo
        $info = array(
            "success" => true,
                "lista" => $lista["datos"],
                "totalPaginas" => $lista["totalPaginas"],
                "paginaActual" => $lista["paginaActual"]
        );
        echo json_encode($info);
    }
    //  obtener 
    elseif ($ope == "OBTENER") {
        if (isset($_POST["ID_Usuario"])) {
            $usuario = $usu->ObtenerUsuario($_POST["ID_Usuario"]);
            if ($usuario) {
                echo json_encode(["success" => true, "usuario" => $usuario]);
            } else {
                echo json_encode(["success" => false, "msg" => "Usuario no encontrado."]);
            }
        } else {
            echo json_encode(["success" => false, "msg" => "ID de usuario no proporcionado."]);
        }
    }
    // para agregar  
    elseif ($ope == "AGREGAR" && isset($_POST["FechaInicio"], $_POST["FechaFin"], $_POST["Costo"], $_POST["Cantidad"], $_POST["FechaPago"], $_POST["ID_Miembro"], $_POST["ID_Membresia"], $_POST["ID_Usuario"])) {
        $datos = array(
            "FechaInicio" => $_POST["FechaInicio"],
            "FechaFin" => $_POST["FechaFin"],
            "Costo" => $_POST["Costo"],
            "Cantidad" => $_POST["Cantidad"],
            "FechaPago" => $_POST["FechaPago"],
            "ID_Miembro" => $_POST["ID_Miembro"],
            "ID_Membresia" => $_POST["ID_Membresia"],
            "ID_Usuario" => $_POST["ID_Usuario"]
        );

        $status = $usu->Agregar($datos);
        $info = array("success" => $status);
        echo json_encode($info);
    }
    // editar  usuario 
    elseif ($ope == "EDITAR" && isset($_POST["ID_Usuario"], $_POST["NombreEdit"], $_POST["ApellidoPEdit"], $_POST["ApellidoMEdit"], $_POST["CorreoUsuEdit"], $_POST["NombreUsuEdit"], $_POST["SalarioEdit"], $_POST["usutipEdit"])) {
        $datos = array(
            "ID_Usuario" => $_POST["ID_Usuario"],
            "Nombre" => $_POST["NombreEdit"],
            "ApellidoP" => $_POST["ApellidoPEdit"],
            "ApellidoM" => $_POST["ApellidoMEdit"],
            "CorreoUsu" => $_POST["CorreoUsuEdit"],
            "NombreUsu" => $_POST["NombreUsuEdit"],
            
            "Salario" => $_POST["SalarioEdit"],
            "usutip" => $_POST["usutipEdit"]
        );

      
        

        $status = $usu->Editar($datos);
        $info = array("success" => $status);
        echo json_encode($info);
    }
    elseif ($_POST["ope"] == "CAMBIAR_CLAVE") {
        $idUsuario = $_POST["ID_Usuario"];
        $claveNueva = $_POST["ClaveNueva"];

        
        $claveEncriptada = password_hash($claveNueva, PASSWORD_DEFAULT);

    
        $status = $usu->cambiarClave($idUsuario, $claveEncriptada);

        echo json_encode(["success" => $status]);
        exit();
    }
    
    // eliminar 
    elseif ($ope == "ELIMINAR" && isset($_POST["ID_Usuario"])) {
        $status = $usu->Eliminar($_POST["ID_Usuario"]);
        $info = array("success" => $status);
        echo json_encode($info);
    }
    elseif ($ope == "OBTENERMEMBRESIAS") {
        $membresias = $usu->ObtenerMembresias();  // Llamar a la función en el modelo
        $info = array(
            "success" => true,
            "membresias" => $membresias
        );
        echo json_encode($info);
    }
    
    else {
        echo json_encode(array("success" => false, "msg" => "Operación no válida o parámetros insuficientes"));
    }
} 

else {
    echo json_encode(array("success" => false, "msg" => "Sin operación válida"));
}
?>
