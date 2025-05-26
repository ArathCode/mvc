<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/ModeloEntrenamientos.php");

    $entrenamiento = new Entrenamientos();

    header('Content-Type: application/json');

    switch ($ope) {
        case "LISTAR_ENTRENAMIENTOS":
            $lista = $entrenamiento->Listar();
            echo json_encode([
                "success" => true,
                "lista" => $lista
            ]);
            break;

        case "AGREGAR_ENTRENAMIENTO":
            if (isset($_POST["Nombre"])) {
                $nombre = $_POST["Nombre"];
                $status = $entrenamiento->Agregar($nombre);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta el nombre del entrenamiento."]);
            }
            break;

        case "ELIMINAR_ENTRENAMIENTO":
            if (isset($_POST["ID_Entrenamiento"])) {
                $id = $_POST["ID_Entrenamiento"];
                $status = $entrenamiento->Eliminar($id);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta el ID del entrenamiento."]);
            }
            break;

        default:
            echo json_encode(["success" => false, "msg" => "Operación no válida."]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Sin operación válida."]);
}
?>
