<?php 
class Gastos {

    public function ListarGastos($fechaInicio = null, $fechaFin = null, $pagina = 1, $registrosPorPagina = 10) {
        $enlace = dbConectar();

        $offset = ($pagina - 1) * $registrosPorPagina;

        // Consulta base
        $sql = "SELECT g.ID_Gasto, g.Descripcion, g.Precio, g.Fecha, u.Nombre 
                FROM gastos g 
                JOIN usuarios u ON g.ID_Usuario = u.ID_Usuario";
        $countSql = "SELECT COUNT(*) as total 
                     FROM gastos g 
                     JOIN usuarios u ON g.ID_Usuario = u.ID_Usuario";

        $parametros = [];
        $tipos = "";

        // Filtrar por fechas si están disponibles
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $sql .= " WHERE g.Fecha BETWEEN ? AND ?";
            $countSql .= " WHERE g.Fecha BETWEEN ? AND ?";
            array_push($parametros, $fechaInicio, $fechaFin);
            $tipos .= "ss";
        }

        // Ordenar y limitar resultados
        $sql .= " ORDER BY g.Fecha DESC LIMIT ?, ?";
        array_push($parametros, $offset, $registrosPorPagina);
        $tipos .= "ii";

        // Obtener el total de registros
        $countConsulta = $enlace->prepare($countSql);
        if (!empty($parametros)) {
            $countConsulta->bind_param(substr($tipos, 0, 2), $parametros[0], $parametros[1]); // Solo parámetros de fechas
        }
        $countConsulta->execute();
        $countResult = $countConsulta->get_result();
        $totalRegistros = $countResult->fetch_assoc()["total"];
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
        $countConsulta->close();

        // Preparar y ejecutar consulta principal
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param($tipos, ...$parametros);
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

    public function Agregar($datos) {
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

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function Editar($datos) {
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

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function Eliminar($ID_gasto) {
        $enlace = dbConectar();
        $sql = "DELETE FROM gastos WHERE ID_Gasto=?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param("i", $ID_gasto);

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function ObtenerGasto($ID_gasto) {
        $enlace = dbConectar();
        $sql = "SELECT ID_Gasto, Descripcion, Precio, Fecha, ID_Usuario FROM gastos WHERE ID_gasto=?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param("i", $ID_gasto);
        $consulta->execute();
        $result = $consulta->get_result();

        $gasto = $result->num_rows > 0 ? $result->fetch_assoc() : null;

        $consulta->close();
        $enlace->close();

        return $gasto;
    }
}
