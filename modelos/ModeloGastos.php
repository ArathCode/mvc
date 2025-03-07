<?php //modelo 
class Gastos
{
    
    public function ListarGastos($fechaInicio = null, $fechaFin = null, $pagina = 1, $registrosPorPagina = 10) {
        $enlace = dbConectar();
    
        // Calcular OFFSET para la paginación
        $offset = ($pagina - 1) * $registrosPorPagina;
    
        // Consulta base
        $sql = "SELECT g.ID_Gasto, g.Descripcion, g.Precio, g.Fecha, u.Nombre 
                FROM gastos g 
                JOIN usuarios u ON g.ID_Usuario = u.ID_Usuario";
    
        $countSql = "SELECT COUNT(*) as total FROM gastos g JOIN usuarios u ON g.ID_Usuario = u.ID_Usuario";
    
        $parametros = [];
        $tipos = ""; // Para bind_param
    
        // Si hay filtro de fechas, agregarlo a la consulta
        if ($fechaInicio && $fechaFin) {
            $sql .= " WHERE g.Fecha BETWEEN ? AND ?";
            $countSql .= " WHERE g.Fecha BETWEEN ? AND ?";
            $parametros[] = $fechaInicio;
            $parametros[] = $fechaFin;
            $tipos .= "ss"; // Ambos son strings
        }
    
        // Ordenar y limitar resultados
        $sql .= " ORDER BY g.Fecha DESC LIMIT ?, ?";
        $parametros[] = $offset;
        $parametros[] = $registrosPorPagina;
        $tipos .= "ii"; // OFFSET y LIMIT son enteros
    
        // Preparar la consulta principal
        $consulta = $enlace->prepare($sql);
        
        // Preparar la consulta de conteo
        $countConsulta = $enlace->prepare($countSql);
    
        // Enlazar parámetros dinámicamente
        if (!empty($parametros)) {
            $consulta->bind_param($tipos, ...$parametros);
        }
    
        // Ejecutar la consulta de conteo
        $countConsulta->execute();
        $countResult = $countConsulta->get_result();
        $totalRegistros = $countResult->fetch_assoc()["total"];
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
    
        // Ejecutar la consulta principal
        $consulta->execute();
        $result = $consulta->get_result();
        $gastos = [];
    
        while ($row = $result->fetch_assoc()) {
            $gastos[] = $row;
        }
    
        $enlace->close();
    
        return [
            "gastos" => $gastos,
            "totalPaginas" => $totalPaginas,
            "paginaActual" => $pagina
        ];
    }
    

    public function Agregar($datos)
    {
        $enlace = dbConectar();
        $sql = "INSERT INTO gastos (Descripcion, Precio, Fecha, ID_Usuario) VALUES (?, ?, ?, ?)";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "sdsi",
            $datos["Descripcion"],
            $datos["Precio"],
            $datos["Fecha"],
            $datos["ID_Usuario"]
           
        );

        return $consulta->execute();
    }

    public function Editar($datos)
    {
        $enlace = dbConectar();
        $sql = "UPDATE gastos SET Descripcion=?, Precio=?, Fecha=?, ID_Usuario=? WHERE ID_Gasto=?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "sdsii",
            $datos["Descripcion"],
            $datos["Precio"],
            $datos["Fecha"],
            $datos["ID_Usuario"],
            $datos["ID_gasto"]
        );

        return $consulta->execute();
    }

    public function Eliminar($ID_gasto)
    {
        $enlace = dbConectar();
        $sql = "DELETE FROM gastos WHERE ID_Gasto=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_gasto);

        return $consulta->execute();
    }

    public function ObtenerGasto($ID_gasto)
    {
        $enlace = dbConectar();
        $sql = "SELECT ID_Gasto, Descripcion, Precio, Fecha, ID_Usuario FROM gastos WHERE ID_gasto=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_gasto);
        $consulta->execute();
        $result = $consulta->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
