<?php //modelo 
class Gastos
{
    public function ListarGastos($fechaInicio = null, $fechaFin = null) {
        $enlace = dbConectar();
        $sql = "SELECT g.ID_Gasto, g.Descripcion, g.Precio, g.Fecha, u.Nombre 
                FROM gastos g 
                JOIN usuarios u ON g.ID_Usuario = u.ID_Usuario";
        
        $parametros = [];
        if ($fechaInicio && $fechaFin) {
            $sql .= " WHERE g.Fecha BETWEEN ? AND ?";
            $parametros[] = $fechaInicio;
            $parametros[] = $fechaFin;
        }
    
        $consulta = $enlace->prepare($sql);
        
        if (!empty($parametros)) {
            $consulta->bind_param("ss", ...$parametros);
        }
    
        $consulta->execute();
        $result = $consulta->get_result();
        $gastos = [];
    
        while ($row = $result->fetch_assoc()) {
            $gastos[] = $row;
        }
    
        $enlace->close();
        return $gastos;
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
