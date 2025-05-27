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
    } elseif ($ope == "OBTENER_Membresias_Activas_Tipo") {
    $datos = $estadisticas->obtenerMembresiasActivasPorTipo();
    echo json_encode(["success" => true, "membresias_activas_tipo" => $datos]);

} elseif ($ope == "OBTENER_Accesos_Diarios") {
    $datos = $estadisticas->obtenerAccesosDiarios();
    echo json_encode(["success" => true, "accesos_diarios" => $datos]);

} elseif ($ope == "OBTENER_Ingresos_Mensuales") {
    $datos = $estadisticas->obtenerIngresosMensuales();
    echo json_encode(["success" => true, "ingresos_mensuales" => $datos]);

} elseif ($ope == "OBTENER_Comparativa_Ingresos_Gastos") {
    $datos = $estadisticas->obtenerComparativaIngresosGastos();
    echo json_encode(["success" => true, "comparativa_ingresos_gastos" => $datos]);
}else {
        echo json_encode(["success" => false, "msg" => "Operación no válida"]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Sin operación válida"]);
}
?>
