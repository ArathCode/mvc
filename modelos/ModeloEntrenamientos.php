<?php
class Entrenamientos {

    public function Listar() {
        $enlace = dbConectar();
        $sql = "SELECT ID_Entrenamiento, Nombre FROM entrenamientos ";
        $resultado = $enlace->query($sql);

        $entrenamientos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $entrenamientos[] = $fila;
        }

        $resultado->close();
        $enlace->close();

        return $entrenamientos;
    }

    public function Agregar($nombre) {
        $enlace = dbConectar();
        $sql = "INSERT INTO entrenamientos (Nombre, Estatus) VALUES (?, '1')";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("s", $nombre);

        $status = $consulta->execute();

        $consulta->close();
        $enlace->close();

        return $status;
    }

    public function Eliminar($ID_Entrenamiento) {
        $enlace = dbConectar();
        $sql = "UPDATE entrenamientos SET Estatus = '0' WHERE ID_Entrenamiento = ?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_Entrenamiento);

        $status = $consulta->execute();

        $consulta->close();
        $enlace->close();

        return $status;
    }
}
?>
