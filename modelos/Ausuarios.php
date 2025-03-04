<?php
class Usuarios
{


    public function ListarTODOS()
    {
        $enlace = dbConectar();
        $sql = "SELECT ID_Usuario, Nombre, ApellidoP, ApellidoM, CorreoUsu, NombreUsu, Salario, usutip FROM usuarios";
        $consulta = $enlace->prepare($sql);
        $consulta->execute();
        $result = $consulta->get_result();

        $usuarios = [];
        while ($usuario = $result->fetch_assoc()) {
            $usuarios[] = $usuario;
        }

        return $usuarios;
    }

    public function Agregar($datos)
    {
        $enlace = dbConectar();
        $sql = "INSERT INTO usuarios (Nombre, ApellidoP, ApellidoM, CorreoUsu, NombreUsu, Contra, Salario, usutip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $consulta = $enlace->prepare($sql);


        $passwordHash = password_hash($datos["Contra"], PASSWORD_DEFAULT);

        $consulta->bind_param(
            "ssssssis",
            $datos["Nombre"],
            $datos["ApellidoP"],
            $datos["ApellidoM"],
            $datos["CorreoUsu"],
            $datos["NombreUsu"],
            $passwordHash,
            $datos["Salario"],
            $datos["usutip"]
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
