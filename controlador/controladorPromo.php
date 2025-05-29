<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/modeloPromos.php");
    $promo = new Promos(); 

    header('Content-Type: application/json');

    function generarUUID() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    switch ($ope) {

        case "LISTAR_ACTIVAS":
            $lista = $promo->ListarActivas();
            echo json_encode([
                "success" => true,
                "lista" => $lista
            ]);
            break;

        case "LISTAR_INACTIVAS":
            $lista = $promo->ListarInactivas();
            echo json_encode([
                "success" => true,
                "lista" => $lista
            ]);
            break;

        case "LISTAR_TODAS":
            $lista = $promo->ListarTodas();
            echo json_encode([
                "success" => true,
                "lista" => $lista
            ]);
            break;

        case "OBTENER":
            if (isset($_POST["id"])) {
                $promoData = $promo->ObtenerPromo($_POST["id"]);
                echo json_encode([
                    "success" => $promoData ? true : false,
                    "promo" => $promoData ?? null,
                    "msg" => $promoData ? "" : "Promo no encontrada."
                ]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta el ID de la promo."]);
            }
            break;

        case "AGREGAR":
            if (
                isset($_POST["title"], $_POST["subtitle"], $_POST["offer_text"], $_POST["description"],
                    $_POST["terms"], $_POST["valid_until"], $_POST["category"], $_POST["is_active"], $_POST["ID_Usuario"])
            ) {
                $uuid = generarUUID(); 

                $datos = [
                    "id" => $uuid,
                    "title" => $_POST["title"],
                    "subtitle" => $_POST["subtitle"],
                    "offer_text" => $_POST["offer_text"],
                    "description" => $_POST["description"],
                    "terms" => $_POST["terms"],
                    "valid_until" => $_POST["valid_until"],
                    "category" => $_POST["category"],
                    "is_active" => $_POST["is_active"],
                    "ID_Usuario" => $_POST["ID_Usuario"]
                ];
                $status = $promo->Agregar($datos);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Faltan datos para agregar la promo."]);
            }
            break;

        case "LISTAR_USUARIOS":
            $resultado = $promo->ListarUsuarios(); 
            echo json_encode($resultado);
            break;

        case "EDITAR":
            if (
                isset($_POST["id"], $_POST["title"], $_POST["subtitle"], $_POST["offer_text"], $_POST["description"],
                    $_POST["terms"], $_POST["valid_until"], $_POST["category"], $_POST["is_active"], $_POST["ID_Usuario"])
            ) {
                $datos = [
                    "id" => $_POST["id"],
                    "title" => $_POST["title"],
                    "subtitle" => $_POST["subtitle"],
                    "offer_text" => $_POST["offer_text"],
                    "description" => $_POST["description"],
                    "terms" => $_POST["terms"],
                    "valid_until" => $_POST["valid_until"],
                    "category" => $_POST["category"],
                    "is_active" => $_POST["is_active"],
                    "ID_Usuario" => $_POST["ID_Usuario"]
                ];
                $status = $promo->Editar($datos);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Faltan datos para editar la promo."]);
            }
            break;

        case "CAMBIAR_ESTADO":
            if (isset($_POST["id"], $_POST["is_active"])) {
                $id = $_POST["id"];
                $estado = $_POST["is_active"]; 

                if ($estado !== "0" && $estado !== "1") {
                    echo json_encode(["success" => false, "msg" => "El estado debe ser 0 o 1."]);
                    break;
                }

                $estado = intval($estado);
                $status = $promo->CambiarEstado($id, $estado);

                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Faltan datos para cambiar el estado de la promo."]);
            }
        break;


        case "ELIMINAR":
            if (isset($_POST["id"])) {
                $status = $promo->Eliminar($_POST["id"]);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta el ID de la promo para eliminar."]);
            }
            break;

        default:
            echo json_encode(["success" => false, "msg" => "Operación no válida o parámetros insuficientes"]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Sin operación válida"]);
}
