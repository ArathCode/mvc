<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/Estadisticas.php");
    $estadisticas = new Estadisticas();

    if ($ope == "OBTENER_Miembros_Sexo") {
        $datos = $estadisticas->obtenerMiembrosPorSexo();
        echo json_encode(["success" => true, "miembros_sexo" => $datos]);
    } elseif ($ope == "OBTENER_Estado_Membresias") {
        $fecha_actual = date('Y-m-d');
        $datos = $estadisticas->obtenerEstadoMembresias($fecha_actual);
        echo json_encode(["success" => true, "estado_membresias" => $datos]);
    } elseif ($ope == "OBTENER_Gastos_Mensuales") {
        $datos = $estadisticas->obtenerGastosMensuales();
        echo json_encode(["success" => true, "gastos_mensuales" => $datos]);
    } else {
        echo json_encode(["success" => false, "msg" => "Operación no válida"]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Sin operación válida"]);
}
?>
