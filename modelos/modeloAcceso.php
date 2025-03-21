<?php
class Accesos
{
    public function agregarAcceso($datos)
    {
    $enlace = dbConectar();
    if (!$enlace) { 
        error_log("Error de conexión: " . mysqli_connect_error());
        return false;
    }
    $sql = "INSERT INTO accesos (Hora, Fecha, Precio, ID_Miembro) VALUES (?, ?, ?, ?)";
    $consulta = $enlace->prepare($sql);
    if (!$consulta) {
        error_log("Error al preparar la consulta: " . $enlace->error); 
        return false;
    }
        $enlace = dbConectar();
        if (!$enlace) { 
            error_log("Error de conexión: " . mysqli_connect_error());
            return false;
        }

        $sql = "INSERT INTO accesos (Hora, Fecha, Precio, ID_Miembro) VALUES (?, ?, ?, ?)";
        $consulta = $enlace->prepare($sql);
        if (!$consulta) {
            error_log("Error al preparar la consulta: " . $enlace->error); 
            return false;
        }

        $consulta->bind_param("ssdi", $datos["Hora"], $datos["Fecha"], $datos["Precio"], $datos["ID_Miembro"]);
        return $consulta->execute();
    }
    public function listarAccesos()
    {
        $enlace = dbConectar();
        $sql = "SELECT a.ID_Acceso, a.Hora, a.Fecha, a.Precio, a.ID_Miembro, 
                       m.Nombre, m.ApellidoP, m.ApellidoM 
                FROM accesos a 
                JOIN miembros m ON a.ID_Miembro = m.ID_Miembro";
        $consulta = $enlace->prepare($sql);
        $consulta->execute();
        $result = $consulta->get_result();

        $accesos = [];
        while ($acceso = $result->fetch_assoc()) {
            $accesos[] = $acceso;
        }

        return $accesos;
    }
    public function buscarMiembroPorID($ID_Miembro)
    {
        $enlace = dbConectar();
        $sql = "SELECT * FROM miembros WHERE ID_Miembro = ?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_Miembro);
        $consulta->execute();
        $result = $consulta->get_result();

        return $result->fetch_assoc();
    }
    public function buscarMiembroPorID2($ID_Miembro)
    {
        $enlace = dbConectar();
        $sql = "SELECT 
                mm.ID_Miembro, 
                m.Nombre, 
                m.ApellidoP, 
                m.ApellidoM, 
                m.Telefono, 
                m.Sexo,
                mm.ID_MiemMiembro,
                mm.FechaInicio,
                mm.FechaFin,
                mm.Costo,
                mm.Cantidad,
                mm.FechaPago
            FROM vista_membresias_vigentes mm
            JOIN miembros m ON mm.ID_Miembro = m.ID_Miembro
            WHERE mm.ID_Miembro = ?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_Miembro);
        $consulta->execute();
        $result = $consulta->get_result();

        return $result->fetch_assoc();
    }
}
