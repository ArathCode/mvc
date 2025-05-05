<?php

// models/MiembroModel.php
class MiembroModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM miembros";
        $resultado = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}
?>
