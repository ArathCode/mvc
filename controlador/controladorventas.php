<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/modeloventas.php");
    $pro = new ventas();

    if ($ope == "LISTAPRODUCTOS") {
        $lista = $pro->ListarPRODUCTOS();
        echo json_encode(["success" => true, "lista" => $lista]);
    } 

    elseif ($ope == "CONFIRMARVENTA") {
        $productos = json_decode($_POST["productos"], true);
        $idUsuario = $_POST["ID_Usuario"];
        $resultado = $pro->RegistrarVenta($productos, $idUsuario);
        echo json_encode($resultado);
    }
     
    elseif ($ope == "VENTAS_DE_HOY") {
        $lista = $pro->ListarVentasDelDia();
        echo json_encode(["success" => true, "lista" => $lista]);
    }
    
    else {
        echo json_encode(["success" => false, "msg" => "Operación no válida"]);
    }
}
?>


