<?php
class Estadisticas
{
    public function obtenerMiembrosPorSexo()
    {
        $enlace = dbConectar();
        $sql = "SELECT Sexo AS tipousu, COUNT(*) AS sum FROM miembros GROUP BY Sexo";
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

    public function obtenerEstadoMembresias($fecha_actual)
    {
        $enlace = dbConectar();
        $sql = "
            SELECT 
                SUM(CASE WHEN FechaFin >= ? THEN 1 ELSE 0 END) AS Vigentes,
                SUM(CASE WHEN FechaFin < ? THEN 1 ELSE 0 END) AS Caducados
            FROM miembro_membresia
        ";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param('ss', $fecha_actual, $fecha_actual);
        $consulta->execute();
        $resultado = $consulta->get_result();

        $datos = $resultado->fetch_assoc();

        $enlace->close();
        return $datos;
    }

    public function obtenerGastosMensuales()
    {
        $enlace = dbConectar();
        $sql = "
            SELECT 
                DATE_FORMAT(Fecha, '%Y-%m') AS Mes,
                SUM(Precio) AS Total
            FROM gastos
            GROUP BY DATE_FORMAT(Fecha, '%Y-%m')
            ORDER BY DATE_FORMAT(Fecha, '%Y-%m') ASC
        ";
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
