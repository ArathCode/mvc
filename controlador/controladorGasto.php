<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/ModeloGastos.php");
    $gasto = new Gastos();

    // Configuración del encabezado para JSON
    header('Content-Type: application/json');

    switch ($ope) {
        case "LISTARGASTOS":
            $pagina = isset($_POST["pagina"]) ? intval($_POST["pagina"]) : 1;
            $registrosPorPagina = isset($_POST["registrosPorPagina"]) ? intval($_POST["registrosPorPagina"]) : 10;
            
            // Manejo de fechas con valores predeterminados
            $fechaInicio = isset($_POST["fechaInicio"]) && !empty($_POST["fechaInicio"]) ? $_POST["fechaInicio"] : "0000-01-01";
            $fechaFin = isset($_POST["fechaFin"]) && !empty($_POST["fechaFin"]) ? $_POST["fechaFin"] : "2100-12-31";

            $lista = $gasto->ListarGastos($fechaInicio, $fechaFin, $pagina, $registrosPorPagina);

            echo json_encode([
                "success" => true,
                "lista" => $lista["gastos"],
                "totalPaginas" => $lista["totalPaginas"],
                "paginaActual" => $lista["paginaActual"]
            ]);
            break;

        case "OBTENER":
            if (isset($_POST["ID_Gasto"])) {
                $gastoData = $gasto->ObtenerGasto($_POST["ID_Gasto"]);
                echo json_encode([
                    "success" => $gastoData ? true : false,
                    "gasto" => $gastoData ?? null,
                    "msg" => $gastoData ? "" : "Gasto no encontrado."
                ]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta el ID del gasto."]);
            }
            break;

        case "AGREGAR":
            if (isset($_POST["Descripcion"], $_POST["Precio"], $_POST["Fecha"], $_POST["ID_Usuario"])) {
                $datos = [
                    "Descripcion" => $_POST["Descripcion"],
                    "Precio" => $_POST["Precio"],
                    "Fecha" => $_POST["Fecha"],
                    "ID_Usuario" => $_POST["ID_Usuario"]
                ];
                $status = $gasto->Agregar($datos);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Faltan datos para agregar el gasto."]);
            }
            break;

        case "EDITAR":
            if (isset($_POST["ID_Gasto"], $_POST["DescripcionEdit"], $_POST["PrecioEdit"], $_POST["FechaEdit"], $_POST["ID_UsuarioEdit"])) {
                $datos = [
                    "ID_gasto" => $_POST["ID_Gasto"],
                    "Descripcion" => $_POST["DescripcionEdit"],
                    "Precio" => $_POST["PrecioEdit"],
                    "Fecha" => $_POST["FechaEdit"],
                    "ID_Usuario" => $_POST["ID_UsuarioEdit"]
                ];
                $status = $gasto->Editar($datos);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Faltan datos para editar el gasto."]);
            }
            break;

        case "ELIMINAR":
            if (isset($_POST["ID_Gasto"])) {
                $status = $gasto->Eliminar($_POST["ID_Gasto"]);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta el ID del gasto para eliminar."]);
            }
            break;

        default:
            echo json_encode(["success" => false, "msg" => "Operación no válida o parámetros insuficientes"]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Sin operación válida"]);
}
?>
