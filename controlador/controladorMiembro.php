<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/ModeloMiembros.php");
    $miembro = new Miembros();

    header('Content-Type: application/json');

    switch ($ope) {
        case "LISTARMIEMBROS":
            $pagina = isset($_POST["pagina"]) ? intval($_POST["pagina"]) : 1;
            $registrosPorPagina = isset($_POST["registrosPorPagina"]) ? intval($_POST["registrosPorPagina"]) : 10;

            $filtros = [
                "ID_Miembro" => $_POST["id"] ?? null,
                "Nombre" => $_POST["nombre"] ?? null,
                "Apellidos" => $_POST["apellidos"] ?? null,
                "Telefono" => $_POST["telefono"] ?? null,
            ];

            $lista = $miembro->ListarMiembros($pagina, $registrosPorPagina, $filtros);

            echo json_encode([
                "success" => true,
                "lista" => $lista["miembros"],
                "totalPaginas" => $lista["totalPaginas"],
                "paginaActual" => $lista["paginaActual"],
            ]);
            break;

        case "OBTENER":
            if (isset($_POST["ID_Miembro"])) {
                $miembroData = $miembro->ObtenerMiembro($_POST["ID_Miembro"]);
                echo json_encode([
                    "success" => $miembroData ? true : false,
                    "miembro" => $miembroData ?? null,
                    "msg" => $miembroData ? "" : "Miembro no encontrado.",
                ]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta el ID del miembro."]);
            }
            break;

        case "AGREGAR":
            if (isset($_POST["Nombre"], $_POST["ApellidoP"], $_POST["ApellidoM"], $_POST["Sexo"], $_POST["Telefono"])) {
                $datos = [
                    "Nombre" => $_POST["Nombre"],
                    "ApellidoP" => $_POST["ApellidoP"],
                    "ApellidoM" => $_POST["ApellidoM"],
                    "Sexo" => $_POST["Sexo"],
                    "Telefono" => $_POST["Telefono"],
                ];
                $status = $miembro->Agregar($datos);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Faltan datos para agregar el miembro."]);
            }
            break;

        case "EDITAR":
            if (isset($_POST["ID_Miembro"], $_POST["NombreEdit"], $_POST["ApellidoPEdit"], $_POST["ApellidoMEdit"], $_POST["SexoEdit"], $_POST["TelefonoEdit"])) {
                $datos = [
                    "ID_Miembro" => $_POST["ID_Miembro"],
                    "Nombre" => $_POST["NombreEdit"],
                    "ApellidoP" => $_POST["ApellidoPEdit"],
                    "ApellidoM" => $_POST["ApellidoMEdit"],
                    "Sexo" => $_POST["SexoEdit"],
                    "Telefono" => $_POST["TelefonoEdit"],
                ];
                $status = $miembro->Editar($datos);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Faltan datos para editar el miembro."]);
            }
            break;

        case "ELIMINAR":
            if (isset($_POST["ID_Miembro"])) {
                $status = $miembro->Eliminar($_POST["ID_Miembro"]);
                echo json_encode(["success" => $status]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta el ID del miembro para eliminar."]);
            }
            break;

        case "BUSCARMIEMBROS":
            if (isset($_POST["criterio"])) {
                $criterio = $_POST["criterio"];
                $resultados = $miembro->BuscarMiembros($criterio);
                echo json_encode([
                    "success" => true,
                    "resultados" => $resultados,
                ]);
            } else {
                echo json_encode(["success" => false, "msg" => "Falta el criterio de búsqueda."]);
            }
            break;

        default:
            echo json_encode(["success" => false, "msg" => "Operación no válida o parámetros insuficientes"]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Sin operación válida"]);
}

?>
