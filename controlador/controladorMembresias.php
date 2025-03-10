<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/ModeloMembresias.php");
    $usu = new Membresias();

    // Operación de Login
   
    // listar 
    if ($ope == "LISTAUSUARIOS") {
        $lista = $usu->ListarTODOS();
        $info = array(
            "success" => true,
            "lista" => $lista
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
    elseif ($ope == "AGREGAR" && isset($_POST["Tipo"], $_POST["Descripcion"], $_POST["Costo"])) {
        $datos = array(
            "Tipo" => $_POST["Tipo"],
            "Descripcion" => $_POST["Descripcion"],
            "Costo" => $_POST["Costo"],
            
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
    
    else {
        echo json_encode(array("success" => false, "msg" => "Operación no válida o parámetros insuficientes"));
    }
} 

else {
    echo json_encode(array("success" => false, "msg" => "Sin operación válida"));
}
?>
