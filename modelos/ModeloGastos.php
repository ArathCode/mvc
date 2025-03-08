<?php //modelo 
class Gastos
{
    
    public function ListarGastos($fechaInicio = null, $fechaFin = null, $pagina = 1, $registrosPorPagina = 10) {
        $enlace = dbConectar();
    
       
        $offset = ($pagina - 1) * $registrosPorPagina;
    
        
        $sql = "SELECT g.ID_Gasto, g.Descripcion, g.Precio, g.Fecha, u.Nombre 
                FROM gastos g 
                JOIN usuarios u ON g.ID_Usuario = u.ID_Usuario";
    
        $countSql = "SELECT COUNT(*) as total 
                     FROM gastos g 
                     JOIN usuarios u ON g.ID_Usuario = u.ID_Usuario";
    
        $parametros = [];
        $tipos = ""; 
    
       
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $sql .= " WHERE g.Fecha BETWEEN ? AND ?";
            $countSql .= " WHERE g.Fecha BETWEEN ? AND ?";
            $parametros[] = $fechaInicio;
            $parametros[] = $fechaFin;
            $tipos .= "ss";
        }
    
        // Ordenar y limitar resultados
        $sql .= " ORDER BY g.Fecha DESC LIMIT ?, ?";
        $parametros[] = $offset;
        $parametros[] = $registrosPorPagina;
        $tipos .= "ii"; 
    
        // Preparar la consulta de conteo
        $countConsulta = $enlace->prepare($countSql);
        if (count($parametros) >= 2) {
            $countConsulta->bind_param("ss", $parametros[0], $parametros[1]);
        }
        $countConsulta->execute();
        $countResult = $countConsulta->get_result();
        $totalRegistros = $countResult->fetch_assoc()["total"];
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
        $countConsulta->close();
    
     
        $consulta = $enlace->prepare($sql);
        if (count($parametros) > 0) {
            $consulta->bind_param($tipos, ...$parametros);
        }
    
        
        $consulta->execute();
        $result = $consulta->get_result();
        $gastos = [];
    
        while ($row = $result->fetch_assoc()) {
            $gastos[] = $row;
        }
    
       
        $consulta->close();
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
