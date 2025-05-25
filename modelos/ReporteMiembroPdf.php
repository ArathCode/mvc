<?php

// models/MiembroModel.php
class MiembroModel
{
    private $db;

    public function __construct($conexion)
    {
        $this->db = $conexion;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT mm.ID_MiemMiembro, mm.FechaInicio, mm.FechaFin, mm.Costo, mm.Cantidad, mm.FechaPago, m.Nombre AS NombreMiembro, m.ApellidoP AS ApellidoPMiembro, m.ApellidoM AS ApellidoMMiembro, mem.Tipo AS TipoMembresia, u.Nombre AS NombreUsuario FROM miembro_membresia mm JOIN miembros m ON mm.ID_Miembro = m.ID_Miembro JOIN membresias mem ON mm.ID_Membresia = mem.ID_Membresia JOIN usuarios u ON mm.ID_Usuario = u.ID_Usuario WHERE mm.FechaPago >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH) ORDER BY mm.FechaFin DESC;";
        $resultado = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
    public function obtenerVentas()
    {
        $sql = "SELECT 
                    v.ID_Venta, 
                    v.Fecha, 
                    u.Nombre AS Usuario, 
                    p.Descripcion AS Producto, 
                    dv.Cantidad, 
                    dv.Subtotal
                FROM 
                    detalle_venta dv
                INNER JOIN 
                    ventas v ON dv.ID_Venta = v.ID_Venta
                INNER JOIN 
                    usuarios u ON v.ID_Usuario = u.ID_Usuario
                INNER JOIN 
                    productos p ON dv.ID_Producto = p.ID_Producto
                WHERE 
                    v.Fecha >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH);";
        $resultado = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
    public function obtenerProductos()
    {
        $sql = "SELECT p.ID_Producto, p.img, p.Descripcion, p.Precio, p.Disponible, t.Descripcion AS TipoProducto 
                FROM productos p
                LEFT JOIN tipoi t ON p.ID_TipoProducto = t.ID_TipoProducto
                ORDER BY p.Disponible DESC";
        $resultado = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}
