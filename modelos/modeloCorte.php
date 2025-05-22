<?php
class Corte
{
    public function obtenerCorte()
    {
        $enlace = dbConectar();
        $sql = "SELECT 'Visita' AS `Tipo`, coalesce(count(`accesos`.`ID_Acceso`),0) AS `Total_Visitas`, coalesce(sum(`accesos`.`Precio`),0) AS `Total_Visitas_Monto`, 0 AS `Total_Ventas`, 0 AS `Total_Ventas_Monto`, 0 AS `Total_Membresias`, 0 AS `Total_Membresias_Monto` FROM `accesos` WHERE cast(`accesos`.`Fecha` as date) = curdate() AND `accesos`.`Tipo` = 'Visita'union all select 'Venta' AS `Tipo`,0 AS `Total_Visitas`,0 AS `Total_Visitas_Monto`,coalesce(count(`ventas`.`ID_Venta`),0) AS `Total_Ventas`,coalesce(sum(`ventas`.`Total`),0) AS `Total_Ventas_Monto`,0 AS `Total_Membresias`,0 AS `Total_Membresias_Monto` from `ventas` where cast(`ventas`.`Fecha` as date) = curdate() union all select 'Membresia' AS `Tipo`,0 AS `Total_Visitas`,0 AS `Total_Visitas_Monto`,0 AS `Total_Ventas`,0 AS `Total_Ventas_Monto`,coalesce(sum(`miembro_membresia`.`Cantidad`),0) AS `Total_Membresias`,coalesce(sum(`miembro_membresia`.`Cantidad` * `miembro_membresia`.`Costo`),0) AS `Total_Membresias_Monto` from `miembro_membresia` where cast(`miembro_membresia`.`FechaPago` as date) = curdate() union all select 'Total General' AS `Tipo`,coalesce(sum(case when `resumen`.`Tipo` = 'Visita' then `resumen`.`Total_Visitas` else 0 end),0) AS `Total_Visitas`,coalesce(sum(case when `resumen`.`Tipo` = 'Visita' then `resumen`.`Total_Visitas_Monto` else 0 end),0) AS `Total_Visitas_Monto`,coalesce(sum(case when `resumen`.`Tipo` = 'Venta' then `resumen`.`Total_Ventas` else 0 end),0) AS `Total_Ventas`,coalesce(sum(case when `resumen`.`Tipo` = 'Venta' then `resumen`.`Total_Ventas_Monto` else 0 end),0) AS `Total_Ventas_Monto`,coalesce(sum(case when `resumen`.`Tipo` = 'Membresia' then `resumen`.`Total_Membresias` else 0 end),0) AS `Total_Membresias`,coalesce(sum(case when `resumen`.`Tipo` = 'Membresia' then `resumen`.`Total_Membresias_Monto` else 0 end),0) AS `Total_Membresias_Monto` from (select 'Visita' AS `Tipo`,count(`accesos`.`ID_Acceso`) AS `Total_Visitas`,sum(`accesos`.`Precio`) AS `Total_Visitas_Monto`,0 AS `Total_Ventas`,0 AS `Total_Ventas_Monto`,0 AS `Total_Membresias`,0 AS `Total_Membresias_Monto` from `accesos` where cast(`accesos`.`Fecha` as date) = curdate() and `accesos`.`Tipo` = 'Visita' union all select 'Venta' AS `Tipo`,0 AS `Total_Visitas`,0 AS `Total_Visitas_Monto`,count(`ventas`.`ID_Venta`) AS `Total_Ventas`,sum(`ventas`.`Total`) AS `Total_Ventas_Monto`,0 AS `Total_Membresias`,0 AS `Total_Membresias_Monto` from `ventas` where cast(`ventas`.`Fecha` as date) = curdate() union all select 'Membresia' AS `Tipo`,0 AS `Total_Visitas`,0 AS `Total_Visitas_Monto`,0 AS `Total_Ventas`,0 AS `Total_Ventas_Monto`,sum(`miembro_membresia`.`Cantidad`) AS `Total_Membresias`,sum(`miembro_membresia`.`Cantidad` * `miembro_membresia`.`Costo`) AS `Total_Membresias_Monto` from `miembro_membresia` where cast(`miembro_membresia`.`FechaPago` as date) = curdate()) `resumen`  ;";
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
