<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/ModeloRutinas.php");
    $rutina = new Rutinas();

    header('Content-Type: application/json');

    switch ($ope) {
        case "ASIGNAR":
            if (isset($_POST["ID_Miembro"], $_POST["Dia"], $_POST["ID_Entrenamiento"])) {
                $datos = [
                    "ID_Miembro" => intval($_POST["ID_Miembro"]),
                    "Dia" => $_POST["Dia"],
                    "ID_Entrenamiento" => intval($_POST["ID_Entrenamiento"])
                ];

                $status = $rutina->Asignar($datos);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Faltan datos para asignar la rutina."]);
            }
            break;

        case "ELIMINAR":
            if (isset($_POST["ID_Miembro"], $_POST["Dia"])) {
                $status = $rutina->Eliminar($_POST["ID_Miembro"], $_POST["Dia"]);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Faltan datos para eliminar la rutina."]);
            }
            break;

        case "OBTENER_RUTINA":
            if (isset($_POST["ID_Miembro"])) {
                $resultado = $rutina->ObtenerPorMiembro($_POST["ID_Miembro"]);
                echo json_encode([
                    "success" => true,
                    "rutina" => $resultado
                ]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta ID del miembro."]);
            }
            break;

        default:
            echo json_encode(["success" => false, "msg" => "Operación no válida o parámetros insuficientes."]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Sin operación válida."]);
}
?>
