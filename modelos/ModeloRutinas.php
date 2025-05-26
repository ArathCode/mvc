<?php
class Rutinas
{

    public function Asignar($datos)
    {
        $enlace = dbConectar();
        $sql = "INSERT INTO miembro_entrenamiento_dia (ID_Miembro, DiaSemana, ID_Entrenamiento)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE ID_Entrenamiento = VALUES(ID_Entrenamiento)";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param("isi", $datos["ID_Miembro"], $datos["DiaSemana"], $datos["ID_Entrenamiento"]);

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function Eliminar($ID_Miembro, $Dia)
    {
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

    // 1. Verificar si el miembro existe
    $sqlMiembro = "SELECT Nombre, ApellidoP, ApellidoM FROM miembros WHERE ID_Miembro = ?";
    $stmtMiembro = $enlace->prepare($sqlMiembro);
    $stmtMiembro->bind_param("i", $ID_Miembro);
    $stmtMiembro->execute();
    $resMiembro = $stmtMiembro->get_result();

    if ($resMiembro->num_rows === 0) {
        // Miembro no existe
        return null;
    }

    $datos = $resMiembro->fetch_assoc();
    $nombreCompleto = $datos['Nombre'] . " " . $datos['ApellidoP'] . " " . $datos['ApellidoM'];

    $sqlRutina = "SELECT DiaSemana, ID_Entrenamiento FROM miembro_entrenamiento_dia WHERE ID_Miembro = ?";
    $stmtRutina = $enlace->prepare($sqlRutina);
    $stmtRutina->bind_param("i", $ID_Miembro);
    $stmtRutina->execute();
    $resRutina = $stmtRutina->get_result();

    $rutinas = [];

    while ($fila = $resRutina->fetch_assoc()) {
        $rutinas[$fila['DiaSemana']] = $fila['ID_Entrenamiento'];
    }

    $stmtMiembro->close();
    $stmtRutina->close();
    $enlace->close();

    // Siempre retorna nombre y rutina (aunque esté vacía)
    return [
        "nombre" => $nombreCompleto,
        "rutina" => $rutinas
    ];
}

}
