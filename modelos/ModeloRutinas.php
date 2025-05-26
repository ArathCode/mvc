<?php
class Rutinas {

    public function Asignar($datos) {
        $enlace = dbConectar();
        $sql = "INSERT INTO rutina_miembro (ID_Miembro, Dia, ID_Entrenamiento)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE ID_Entrenamiento = VALUES(ID_Entrenamiento)";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param("isi", $datos["ID_Miembro"], $datos["Dia"], $datos["ID_Entrenamiento"]);

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function Eliminar($ID_Miembro, $Dia) {
        $enlace = dbConectar();
        $sql = "DELETE FROM rutina_miembro WHERE ID_Miembro = ? AND Dia = ?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param("is", $ID_Miembro, $Dia);

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function ObtenerPorMiembro($ID_Miembro) {
        $enlace = dbConectar();
        $sql = "SELECT DiaSemana, ID_Entrenamiento FROM miembro_entrenamiento_dia WHERE ID_Miembro = ?";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param("i", $ID_Miembro);
        $consulta->execute();

        $resultado = $consulta->get_result();
        $rutinas = [];

        while ($fila = $resultado->fetch_assoc()) {
            $rutinas[$fila['DiaSemana']] = $fila['ID_Entrenamiento'];
        }

        $consulta->close();
        $enlace->close();

        return $rutinas;
    }
}
?>
