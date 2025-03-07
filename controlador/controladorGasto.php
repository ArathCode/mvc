<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/ModeloGastos.php");
    $gasto = new Gastos();

    // Listar gastos
    if ($ope == "LISTARGASTOS") {
        $pagina = isset($_POST["pagina"]) ? intval($_POST["pagina"]) : 1;
        $registrosPorPagina = isset($_POST["registrosPorPagina"]) ? intval($_POST["registrosPorPagina"]) : 10;
    
        $fechaInicio = isset($_POST["fechaInicio"]) ? $_POST["fechaInicio"] : null;
        $fechaFin = isset($_POST["fechaFin"]) ? $_POST["fechaFin"] : null;
    
        $lista = $gasto->ListarGastos($fechaInicio, $fechaFin, $pagina, $registrosPorPagina);
    
        $info = array(
            "success" => true,
            "lista" => $lista["gastos"],
            "totalPaginas" => $lista["totalPaginas"],
            "paginaActual" => $lista["paginaActual"]
        );
    
        echo json_encode($info);
    }
    
    // Obtener un gasto
    elseif ($ope == "OBTENER" && isset($_POST["ID_Gasto"])) {
        $gastoData = $gasto->ObtenerGasto($_POST["ID_Gasto"]);
        if ($gastoData) {
            echo json_encode(["success" => true, "gasto" => $gastoData]);
        } else {
            echo json_encode(["success" => false, "msg" => "Gasto no encontrado."]);
        }
    }
    // Agregar un gasto
    elseif ($ope == "AGREGAR" && isset($_POST["Descripcion"], $_POST["Precio"], $_POST["Fecha"], $_POST["ID_Usuario"])) {
        $datos = array(
            "Descripcion" => $_POST["Descripcion"],
            "Precio" => $_POST["Precio"],
            "Fecha" => $_POST["Fecha"],
            "ID_Usuario" => $_POST["ID_Usuario"]
           
        );

        $status = $gasto->Agregar($datos);
        $info = array("success" => $status);
        echo json_encode($info);
    }
    // Editar un gasto
    elseif ($ope == "EDITAR" && isset($_POST["ID_Gasto"], $_POST["DescripcionEdit"], $_POST["PrecioEdit"], $_POST["FechaEdit"], $_POST["ID_UsuarioEdit"])) {
        $datos = array(
            "ID_gasto" => $_POST["ID_Gasto"],
            "Descripcion" => $_POST["DescripcionEdit"],
            "Precio" => $_POST["PrecioEdit"],
            "Fecha" => $_POST["FechaEdit"],
            "ID_Usuario" => $_POST["ID_UsuarioEdit"]
         
        );

        $status = $gasto->Editar($datos);
        $info = array("success" => $status);
        echo json_encode($info);
    }
    // Eliminar un gasto
    elseif ($ope == "ELIMINAR" && isset($_POST["ID_Gasto"])) {
        $status = $gasto->Eliminar($_POST["ID_Gasto"]);
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
