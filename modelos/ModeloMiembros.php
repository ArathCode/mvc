<?php 
class Miembros {

    public function ListarMiembros($pagina = 1, $registrosPorPagina = 10, $filtros = []) {
        $enlace = dbConectar();
        $offset = ($pagina - 1) * $registrosPorPagina;

        $sql = "SELECT ID_Miembro, Nombre, ApellidoP, ApellidoM, Sexo, Telefono,pin FROM miembros WHERE 1=1 AND Estatus=1";

        if (isset($filtros['ID_Miembro'])) {
            $sql .= " AND ID_Miembro LIKE ?";
        }
        if (isset($filtros['Nombre'])) {
            $sql .= " AND Nombre LIKE ?";
        }
        if (isset($filtros['Apellidos'])) {
            $sql .= " AND CONCAT(ApellidoP, ' ', ApellidoM) LIKE ?";
        }
        if (isset($filtros['Telefono'])) {
            $sql .= " AND Telefono LIKE ?";
        }

        $sql .= " ORDER BY ID_Miembro DESC LIMIT ?, ?";

        $values = [];
        if (isset($filtros['ID_Miembro'])) {
            $values[] = "%" . $filtros['ID_Miembro'] . "%";
        }
        if (isset($filtros['Nombre'])) {
            $values[] = "%" . $filtros['Nombre'] . "%";
        }
        if (isset($filtros['Apellidos'])) {
            $values[] = "%" . $filtros['Apellidos'] . "%";
        }
        if (isset($filtros['Telefono'])) {
            $values[] = "%" . $filtros['Telefono'] . "%";
        }
        $values[] = $offset;
        $values[] = $registrosPorPagina;

        // Preparar y ejecutar la consulta
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param(str_repeat("s", count($values) - 2) . "ii", ...$values);
        $consulta->execute();
        $result = $consulta->get_result();

        $miembros = [];
        while ($row = $result->fetch_assoc()) {
            $miembros[] = $row;
        }

        // Obtener el total de registros sin filtros
        $countSql = "SELECT COUNT(*) as total FROM miembros WHERE 1=1";
        $countConsulta = $enlace->prepare($countSql);
        $countConsulta->execute();
        $countResult = $countConsulta->get_result();
        $totalRegistros = $countResult->fetch_assoc()["total"];
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
        $countConsulta->close();

        $consulta->close();
        $enlace->close();

        return [
            "miembros" => $miembros,
            "totalPaginas" => $totalPaginas,
            "paginaActual" => $pagina,
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
            $datos["Telefono"],
        );

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function Editar($datos) {
        $enlace = dbConectar();
        $sql = "UPDATE miembros SET Nombre=?, ApellidoP=?, ApellidoM=?, Sexo=?, Telefono=?, WHERE ID_Miembro=?";
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
        $sql = "UPDATE miembros SET Estatus = '0' WHERE ID_Miembro=?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param("i", $ID_Miembro);

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function ObtenerMiembro($ID_Miembro) {
        $enlace = dbConectar();
        $sql = "SELECT ID_Miembro, Nombre, ApellidoP, ApellidoM, Sexo, Telefono, pin FROM miembros WHERE ID_Miembro=?";
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
