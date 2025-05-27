<?php
class Promos {

    public function ListarTodas() {
        $enlace = dbConectar();
        $sql = "SELECT id, title, subtitle, offer_text, description, terms, valid_until, category, is_active, ID_Usuario FROM promo";
        $resultado = $enlace->query($sql);
        $promos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $promos[] = $fila;
        }

        $enlace->close();
        return $promos;
    }

    public function ListarActivas() {
        $enlace = dbConectar();
        $sql = "SELECT id, title, subtitle, offer_text, description, terms, valid_until, category, is_active, ID_Usuario FROM promo WHERE is_active = 1";
        $resultado = $enlace->query($sql);
        $promos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $promos[] = $fila;
        }

        $enlace->close();
        return $promos;
    }

    public function ListarInactivas() {
        $enlace = dbConectar();
        $sql = "SELECT id, title, subtitle, offer_text, description, terms, valid_until, category, is_active, ID_Usuario FROM promo WHERE is_active = 0";
        $resultado = $enlace->query($sql);
        $promos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $promos[] = $fila;
        }

        $enlace->close();
        return $promos;
    }

    public function Agregar($datos) {
        $enlace = dbConectar();
        $sql = "INSERT INTO promo (id, title, subtitle, offer_text, description, terms, valid_until, category, is_active, ID_Usuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $consulta = $enlace->prepare($sql);
        $consulta->bind_param(
            "ssssssssii",
            $datos["id"],
            $datos["title"],
            $datos["subtitle"],
            $datos["offer_text"],
            $datos["description"],
            $datos["terms"],
            $datos["valid_until"],
            $datos["category"],
            $datos["is_active"],
            $datos["ID_Usuario"]
        );

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }


    public function Editar($datos) {
        $enlace = dbConectar();
        $sql = "UPDATE promo SET title=?, subtitle=?, offer_text=?, description=?, terms=?, valid_until=?, category=?, is_active=?, ID_Usuario=? 
                WHERE id=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param(
            "sssssssiss",
            $datos["title"],
            $datos["subtitle"],
            $datos["offer_text"],
            $datos["description"],
            $datos["terms"],
            $datos["valid_until"],
            $datos["category"],
            $datos["is_active"],
            $datos["ID_Usuario"],
            $datos["id"]
        );

        $resultado = $consulta->execute();
        $consulta->close();
        $enlace->close();

        return $resultado;
    }

    public function Eliminar($id) {
        $enlace = dbConectar();
        $sql = "DELETE FROM promo WHERE id=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("s", $id);
        $resultado = $consulta->execute();

        $consulta->close();
        $enlace->close();

        return $resultado;
    }
    public function ListarUsuarios() {
        $enlace = dbConectar();
        $sql = "SELECT ID_Usuario, CONCAT(Nombre, ' ', ApellidoP) AS nombre_completo FROM usuarios";
        $resultado = $enlace->query($sql);

        $usuarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }

        $enlace->close();
        return $usuarios;
    }



    public function ObtenerPromo($id) {
        $enlace = dbConectar();
        $sql = "SELECT id, title, subtitle, offer_text, description, terms, valid_until, category, is_active, ID_Usuario 
                FROM promo 
                WHERE id=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("s", $id);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $promo = $resultado->fetch_assoc();

        $consulta->close();
        $enlace->close();

        return $promo;
    }
}
?>
