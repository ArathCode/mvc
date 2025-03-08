<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/modeloAcceso.php");
    $acceso = new Accesos();

    if ($ope === "AGREGAR_ACCESO") {
        // Validar campos requeridos
        if (!isset($_POST["Hora"], $_POST["Fecha"], $_POST["Precio"], $_POST["ID_Miembro"])) {
            echo json_encode(["success" => false, "msg" => "Datos incompletos."]);
            exit;
        }
    
        // Depurar datos recibidos
        error_log("Datos recibidos: " . print_r($_POST, true));
    
        $datos = array(
            "Hora" => $_POST["Hora"],
            "Fecha" => $_POST["Fecha"],
            "Precio" => $_POST["Precio"],
            "ID_Miembro" => $_POST["ID_Miembro"]
        );
    
        $status = $acceso->agregarAcceso($datos);
        echo json_encode(["success" => $status]);
    }    
    elseif ($ope === "LISTAR_ACCESOS") {
        $lista = $acceso->listarAccesos();
        echo json_encode(["success" => true, "accesos" => $lista]);
    } 
    elseif ($ope === "BUSCAR_MIEMBRO") {
        if (isset($_POST["ID_Miembro"])) {
            $miembro = $acceso->buscarMiembroPorID($_POST["ID_Miembro"]);
            if ($miembro) {
                echo json_encode(["success" => true, "miembro" => $miembro]);
            } else {
                echo json_encode(["success" => false, "msg" => "Miembro no encontrado."]);
            }
        } else {
            echo json_encode(["success" => false, "msg" => "ID de miembro no proporcionado."]);
        }
    } 
    else {
        echo json_encode(["success" => false, "msg" => "Operación no válida."]);
    }
}

?>
