<?php
class Usuarios
{


    public function ListarTODOS($pagina = 1, $registrosPorPagina = 10)
    {

        $enlace = dbConectar();
        $offset = ($pagina - 1) * $registrosPorPagina;
        $sql = "SELECT 
                mm.ID_MiemMiembro, 
                mm.FechaInicio, 
                mm.FechaFin, 
                mm.Costo, 
                mm.Cantidad, 
                mm.FechaPago, 
                m.Nombre AS NombreMiembro, 
                m.ApellidoP AS ApellidoPMiembro, 
                m.ApellidoM AS ApellidoMMiembro, 
                mem.Tipo AS TipoMembresia, 
                u.Nombre AS NombreUsuario
            FROM miembro_membresia mm
            JOIN miembros m ON mm.ID_Miembro = m.ID_Miembro
            JOIN membresias mem ON mm.ID_Membresia = mem.ID_Membresia
            JOIN usuarios u ON mm.ID_Usuario = u.ID_Usuario
             LIMIT ?, ?";

        $countSql = "SELECT COUNT(*) as total FROM miembro_membresia";

        // Obtener total de registros
        $countConsulta = $enlace->prepare($countSql);
        $countConsulta->execute();
        $countResult = $countConsulta->get_result();
        $totalRegistros = $countResult->fetch_assoc()["total"];
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
        $countConsulta->close();

        // Ejecutar consulta principal
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("ii", $offset, $registrosPorPagina);
        $consulta->execute();
        $result = $consulta->get_result();

        $datos = [];
        while ($fila = $result->fetch_assoc()) {
            $datos[] = $fila;
        }

        return [
            "datos" => $datos,
            "totalPaginas" => $totalPaginas,
            "paginaActual" => $pagina
        ];
    }
    public function ObtenerMembresias()
    {
        $enlace = dbConectar();
        $sql = "SELECT ID_Membresia, Tipo, Costo,Duracion FROM membresias";  // Suponiendo que la tabla se llama 'membresias'
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
        $sql = "INSERT INTO miembro_membresia (ID_Miembro, ID_Membresia, ID_Usuario, Costo, Cantidad, FechaInicio, FechaFin, FechaPago) 
            VALUES (?, ?, ?, ?, ?, ?, ?,?)";

        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "iiidisss",
            $datos["ID_Miembro"],
            $datos["ID_Membresia"],
            $datos["ID_Usuario"],
            $datos["Costo"],
            $datos["Cantidad"],
            $datos["FechaInicio"],
            $datos["FechaFin"],
            $datos["FechaPago"]
        );

        return $consulta->execute();
    }
    public function Editar($datos)
    {
        $enlace = dbConectar();

        if (isset($datos["Contra"])) {
            $sql = "UPDATE usuarios SET Nombre=?, ApellidoP=?, ApellidoM=?, CorreoUsu=?, NombreUsu=?,  Salario=?, usutip=? WHERE ID_Usuario=?";
            $consulta = $enlace->prepare($sql);

            $consulta->bind_param(
                "sssssisi",
                $datos["Nombre"],
                $datos["ApellidoP"],
                $datos["ApellidoM"],
                $datos["CorreoUsu"],
                $datos["NombreUsu"],

                $datos["Salario"],
                $datos["usutip"],
                $datos["ID_Usuario"]
            );
        } else {
            $sql = "UPDATE usuarios SET Nombre=?, ApellidoP=?, ApellidoM=?, CorreoUsu=?, NombreUsu=?, Salario=?, usutip=? WHERE ID_Usuario=?";
            $consulta = $enlace->prepare($sql);
            $consulta->bind_param(
                "sssssisi",
                $datos["Nombre"],
                $datos["ApellidoP"],
                $datos["ApellidoM"],
                $datos["CorreoUsu"],
                $datos["NombreUsu"],
                $datos["Salario"],
                $datos["usutip"],
                $datos["ID_Usuario"]
            );
        }

        return $consulta->execute();
    }
    public function cambiarClave($idUsuario, $claveEncriptada)
    {
        $enlace = dbConectar();
        $sql = "UPDATE usuarios SET Contra=? WHERE ID_Usuario=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("si", $claveEncriptada, $idUsuario);
        $resultado = $consulta->execute();
        $enlace->close();
        return $resultado;
    }

    public function Eliminar($ID_usuario)
    {
        $enlace = dbConectar();
        $sql = "DELETE FROM usuarios WHERE ID_Usuario=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_usuario);

        return $consulta->execute();
    }
    public function ObtenerUsuario($ID_usuario)
    {
        $enlace = dbConectar();
        $sql = "SELECT ID_Usuario, Nombre, ApellidoP, ApellidoM, CorreoUsu, NombreUsu, Contra, Salario, usutip FROM usuarios WHERE ID_Usuario=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_usuario);
        $consulta->execute();
        $result = $consulta->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
