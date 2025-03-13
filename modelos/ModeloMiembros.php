<?php 
class Miembros {

    public function ListarMiembros($pagina = 1, $registrosPorPagina = 10) {
        $enlace = dbConectar();
        $offset = ($pagina - 1) * $registrosPorPagina;

        // Consulta para obtener los miembros
        $sql = "SELECT ID_Miembro, Nombre, ApellidoP, ApellidoM, Sexo, Telefono 
                FROM miembros 
                ORDER BY ID_Miembro DESC 
                LIMIT ?, ?";
        
        // Consulta para obtener el total de registros
        $countSql = "SELECT COUNT(*) as total FROM miembros";

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

        $miembros = [];
        while ($row = $result->fetch_assoc()) {
            $miembros[] = $row;
        }

        $consulta->close();
        $enlace->close();

        return [
            "miembros" => $miembros,
            "totalPaginas" => $totalPaginas,
            "paginaActual" => $pagina
        ];
    }

    public function Agregar($datos) {
        $enlace = dbConectar();
        $sql = "INSERT INTO miembros (Nombre, ApellidoP, ApellidoM, Sexo, Telefono) VALUES (?, ?, ?, ?, ?)";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "sssss",
            $datos["Nombre"],
            $datos["ApellidoP"],
            $datos["ApellidoM"],
            $datos["Sexo"],
            $datos["Telefono"]
        );

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function Editar($datos) {
        $enlace = dbConectar();
        $sql = "UPDATE miembros SET Nombre=?, ApellidoP=?, ApellidoM=?, Sexo=?, Telefono=? WHERE ID_Miembro=?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "sssssi",
            $datos["Nombre"],
            $datos["ApellidoP"],
            $datos["ApellidoM"],
            $datos["Sexo"],
            $datos["Telefono"],
            $datos["ID_Miembro"]
        );

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function Eliminar($ID_Miembro) {
        $enlace = dbConectar();
        $sql = "DELETE FROM miembros WHERE ID_Miembro=?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param("i", $ID_Miembro);

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function ObtenerMiembro($ID_Miembro) {
        $enlace = dbConectar();
        $sql = "SELECT ID_Miembro, Nombre, ApellidoP, ApellidoM, Sexo, Telefono FROM miembros WHERE ID_Miembro=?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param("i", $ID_Miembro);
        $consulta->execute();
        $result = $consulta->get_result();

        $miembro = $result->num_rows > 0 ? $result->fetch_assoc() : null;

        $consulta->close();
        $enlace->close();

        return $miembro;
    }
}
?>
