<?php //modelo 
class Gastos
{
    public function ListarGastos()
{
    $enlace = dbConectar();
    $sql = "SELECT gastos.*, Usuarios.Nombre 
            FROM gastos 
            JOIN Usuarios ON gastos.ID_Usuario = Usuarios.ID_Usuario";
    $consulta = $enlace->prepare($sql);
    $consulta->execute();
    $result = $consulta->get_result();

    $gastos = [];
    while ($gasto = $result->fetch_assoc()) {
        $gastos[] = $gasto;
    }

    return $gastos;
}

    public function Agregar($datos)
    {
        $enlace = dbConectar();
        $sql = "INSERT INTO gastos (Descripcion, Precio, Fecha) VALUES (?, ?, ?)";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "sds",
            $datos["Descripcion"],
            $datos["Precio"],
            $datos["Fecha"]
           
        );

        return $consulta->execute();
    }

    public function Editar($datos)
    {
        $enlace = dbConectar();
        $sql = "UPDATE gastos SET Descripcion=?, Precio=?, Fecha=? WHERE ID_Gasto=?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "sdsi",
            $datos["Descripcion"],
            $datos["Precio"],
            $datos["Fecha"],
          
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
