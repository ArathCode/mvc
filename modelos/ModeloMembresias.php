<?php
class Membresias
{
    public function ListarTODOS()
    {
        $enlace = dbConectar();
        $sql = "SELECT * FROM membresias Where Estatus = 1";
        $consulta = $enlace->prepare($sql);
        $consulta->execute();
        $result = $consulta->get_result();

        $membresias = [];
        while ($membresia = $result->fetch_assoc()) {
            $membresias[] = $membresia;
        }

        return $membresias;
    }

    public function Agregar($datos)
    {
        $enlace = dbConectar();
        $sql = "INSERT INTO membresias (Tipo, Descripcion, Costo, Duracion ) VALUES (?, ?, ?, ?)";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "ssis",
            $datos["Tipo"],
            $datos["Descripcion"],
            $datos["Costo"],
            $datos["Duracion"]
        );

        return $consulta->execute();
    }

    public function Editar($datos)
    {
        $enlace = dbConectar();
        $sql = "UPDATE membresias SET Tipo=?, Descripcion=?, Costo=?, Duracion =? WHERE ID_Membresia=?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "ssisi",
            $datos["Tipo"],
            $datos["Descripcion"],
            $datos["Costo"],
            $datos["Duracion"],
            $datos["ID_Membresia"]
        );

        return $consulta->execute();
    }

    public function Eliminar($ID_Membresia)
    {
        $enlace = dbConectar();
        $sql = "UPDATE membresias SET Estatus = '0' WHERE ID_Membresia=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_Membresia);

        return $consulta->execute();
    }

    public function ObtenerMembresia($ID_Membresia)
    {
        $enlace = dbConectar();
        $sql = "SELECT * FROM membresias WHERE ID_Membresia=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_Membresia);
        $consulta->execute();
        $result = $consulta->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>
