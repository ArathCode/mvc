<?php
include_once("../config.php");

$enlace = dbConectar();
$sql = "SELECT ID_TipoProducto, Descripcion FROM tipoi";
$consulta = $enlace->prepare($sql);
$consulta->execute();
$result = $consulta->get_result();

$tipos = [];
while ($fila = $result->fetch_assoc()) {
    $tipos[] = $fila;
}

echo json_encode($tipos);
?>
