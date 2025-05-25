<?php

class ventas
{

    //Listar productos
    public function ListarPRODUCTOS()
    {
        $enlace = dbConectar();
        $sql = "SELECT p.ID_Producto, p.img, p.Descripcion, p.Precio, p.Disponible, t.Descripcion AS TipoProducto 
                FROM productos p
                LEFT JOIN tipoi t ON p.ID_TipoProducto = t.ID_TipoProducto";
        
        $consulta = $enlace->prepare($sql);
        $consulta->execute();
        $result = $consulta->get_result();

        $productos = [];
        while ($producto = $result->fetch_assoc()) {
            $productos[] = $producto;
        }

        return $productos;
    }

    //Vender
    public function RegistrarVenta($productos, $idUsuario)
    {
        $enlace = dbConectar();
        $enlace->autocommit(false);

        try {
            $total = array_reduce($productos, function ($acc, $p) {
                return $acc + ($p["precio"] * $p["cantidad"]);
            }, 0);

            $sqlVenta = "INSERT INTO ventas (Fecha, Total, ID_Usuario) VALUES (NOW(), ?, ?)";
            $stmt = $enlace->prepare($sqlVenta);
            $stmt->bind_param("di", $total, $idUsuario);
            $stmt->execute();
            $idVenta = $stmt->insert_id;

            foreach ($productos as $producto) {
                $sqlCheck = "SELECT Disponible FROM productos WHERE ID_Producto = ?";
                $stmtCheck = $enlace->prepare($sqlCheck);
                $stmtCheck->bind_param("i", $producto["id"]);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();
                $row = $resultCheck->fetch_assoc();

                if ($row["Disponible"] < $producto["cantidad"]) {
                    return ["success" => false, "msg" => "No hay suficiente stock del producto: " . $producto["descripcion"]];
                }

                $subtotal = $producto["precio"] * $producto["cantidad"];

                $sqlDetalle = "INSERT INTO detalle_venta (ID_Venta, ID_Producto, Cantidad, Subtotal) 
                            VALUES (?, ?, ?, ?)";
                $stmtDetalle = $enlace->prepare($sqlDetalle);
                $stmtDetalle->bind_param("iiid", $idVenta, $producto["id"], $producto["cantidad"], $subtotal);
                $stmtDetalle->execute();

                $sqlActualizarStock = "UPDATE productos SET Disponible = Disponible - ? WHERE ID_Producto = ?";
                $stmtStock = $enlace->prepare($sqlActualizarStock);
                $stmtStock->bind_param("ii", $producto["cantidad"], $producto["id"]);
                $stmtStock->execute();
            }

            $enlace->commit();
            return ["success" => true];
        } catch (Exception $e) {
            $enlace->rollback();
            return ["success" => false, "msg" => $e->getMessage()];
        }
    }

    //listar ventas
    public function ListarVentasDelDia()
    {
        $enlace = dbConectar();
        $sql = "SELECT v.ID_Venta, v.Fecha, u.Nombre AS Usuario, p.Descripcion AS Producto, 
                    dv.Cantidad, dv.Subtotal
                FROM detalle_venta dv
                INNER JOIN ventas v ON dv.ID_Venta = v.ID_Venta
                INNER JOIN usuarios u ON v.ID_Usuario = u.ID_Usuario
                INNER JOIN productos p ON dv.ID_Producto = p.ID_Producto
                WHERE DATE(v.Fecha) = CURDATE()";

        $consulta = $enlace->prepare($sql);
        $consulta->execute();
        $result = $consulta->get_result();

        $ventas = [];
        while ($venta = $result->fetch_assoc()) {
            $ventas[] = $venta;
        }

        return $ventas;
    }
    public function ListarVentas()
    {
        $enlace = dbConectar();
        $sql = "SELECT v.ID_Venta, v.Fecha, u.Nombre AS Usuario, p.Descripcion AS Producto, 
                    dv.Cantidad, dv.Subtotal
                FROM detalle_venta dv
                INNER JOIN ventas v ON dv.ID_Venta = v.ID_Venta
                INNER JOIN usuarios u ON v.ID_Usuario = u.ID_Usuario
                INNER JOIN productos p ON dv.ID_Producto = p.ID_Producto
              ";

        $consulta = $enlace->prepare($sql);
        $consulta->execute();
        $result = $consulta->get_result();

        $ventas = [];
        while ($venta = $result->fetch_assoc()) {
            $ventas[] = $venta;
        }

        return $ventas;
    }
}
?>


