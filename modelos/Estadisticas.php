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
    public function obtenerMembresiasActivasPorTipo()
{
    $enlace = dbConectar();
    $sql = "SELECT m.Tipo AS tipousu, COUNT(*) AS sum
            FROM miembro_membresia mm
            JOIN membresias m ON mm.ID_Membresia = m.ID_Membresia
            WHERE CURDATE() BETWEEN mm.FechaInicio AND mm.FechaFin
            GROUP BY m.Tipo";
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
public function obtenerAccesosDiarios()
{
    $enlace = dbConectar();
    $sql = "SELECT Fecha AS tipousu, COUNT(*) AS sum
            FROM accesos
            WHERE Fecha >= CURDATE() - INTERVAL 30 DAY
            GROUP BY Fecha
            ORDER BY Fecha ASC";
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
public function obtenerComparativaIngresosGastos()
{
    $enlace = dbConectar();
    $sql = "SELECT m.Mes AS tipousu,
                   COALESCE(v.Ventas, 0) AS ingresos,
                   COALESCE(g.Gastos, 0) AS gastos
            FROM (
                SELECT DISTINCT DATE_FORMAT(Fecha, '%Y-%m') AS Mes FROM (
                    SELECT Fecha FROM ventas
                    UNION
                    SELECT Fecha FROM gastos
                ) AS t
            ) m
            LEFT JOIN (
                SELECT DATE_FORMAT(Fecha, '%Y-%m') AS Mes, SUM(Total) AS Ventas
                FROM ventas
                GROUP BY Mes
            ) v ON m.Mes = v.Mes
            LEFT JOIN (
                SELECT DATE_FORMAT(Fecha, '%Y-%m') AS Mes, SUM(Precio) AS Gastos
                FROM gastos
                GROUP BY Mes
            ) g ON m.Mes = g.Mes
            ORDER BY m.Mes ASC";

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
public function obtenerIngresosMensuales()
{
    $enlace = dbConectar();
    $sql = "SELECT DATE_FORMAT(Fecha, '%Y-%m') AS tipousu, SUM(Total) AS sum
            FROM ventas
            GROUP BY tipousu
            ORDER BY tipousu ASC";
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
