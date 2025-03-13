<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/ModeloMembresias.php");
    $membresia = new Membresias();

    // listar
    if ($ope == "LISTAMEMBRESIAS") {
        $lista = $membresia->ListarTODOS();
        $info = array(
            "success" => true,
            "lista" => $lista
        );
        echo json_encode($info);
    }
    // obtener
    elseif ($ope == "OBTENER") {
        if (isset($_POST["ID_Membresia"])) {
            $membresiaData = $membresia->ObtenerMembresia($_POST["ID_Membresia"]);
            if ($membresiaData) {
                echo json_encode(["success" => true, "membresia" => $membresiaData]);
            } else {
                echo json_encode(["success" => false, "msg" => "Membresía no encontrada."]);
            }
        } else {
            echo json_encode(["success" => false, "msg" => "ID de membresía no proporcionado."]);
        }
    }
    // para agregar
    elseif ($ope == "AGREGAR" && isset($_POST["Tipo"], $_POST["Descripcion"], $_POST["Costo"])) {
        $datos = array(
            "Tipo" => $_POST["Tipo"],
            "Descripcion" => $_POST["Descripcion"],
            "Costo" => $_POST["Costo"]
        );

        $status = $membresia->Agregar($datos);
        $info = array("success" => $status);
        echo json_encode($info);
    }
    // editar membresía
    elseif ($ope == "EDITAR" && isset($_POST["ID_Membresia"], $_POST["TipoEdit"], $_POST["DescripcionEdit"], $_POST["CostoEdit"])) {
        $datos = array(
            "ID_Membresia" => $_POST["ID_Membresia"],
            "Tipo" => $_POST["TipoEdit"],
            "Descripcion" => $_POST["DescripcionEdit"],
            "Costo" => $_POST["CostoEdit"]
        );

        $status = $membresia->Editar($datos);
        $info = array("success" => $status);
        echo json_encode($info);
    }
    // eliminar
    elseif ($ope == "ELIMINAR" && isset($_POST["ID_Membresia"])) {
        $status = $membresia->Eliminar($_POST["ID_Membresia"]);
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
