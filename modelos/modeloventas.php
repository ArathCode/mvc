<?php

class ventas
{
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

    public function RegistrarVenta($productos)
    {
        $enlace = dbConectar();
        $enlace->autocommit(false);

        try {
            $total = array_reduce($productos, function ($acc, $p) {
                return $acc + ($p["precio"] * $p["cantidad"]);
            }, 0);

            $sqlVenta = "INSERT INTO ventas (Fecha, Total) VALUES (NOW(), ?)";
            $stmt = $enlace->prepare($sqlVenta);
            $stmt->bind_param("d", $total);
            $stmt->execute();
            $idVenta = $stmt->insert_id;

            foreach ($productos as $producto) {
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
}
?>


