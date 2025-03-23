<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/modeloCorte.php");
    $corte = new Corte();

    if ($ope == "OBTENER_CORTE") {
        $datos = $corte->obtenerCorte();
        // Aseguramos que los datos se están enviando correctamente
        echo json_encode(["success" => true, "corte" => $datos]);
    } else {
        echo json_encode(["success" => false, "msg" => "Operación no válida"]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Sin operación válida"]);
}
?>
