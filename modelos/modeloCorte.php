<?php
class Corte
{
    public function obtenerCorte()
    {
        $enlace = dbConectar();
        $sql = "SELECT * FROM vista_corte";
        $consulta = $enlace->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->get_result();
        
        $datos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }

        $enlace->close();
        return $datos;
    }
}
?>
