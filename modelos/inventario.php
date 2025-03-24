<?php

class inventario
{

    //listar
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

    //agregar nuevo
    public function Agregar($datos){

        $enlace = dbConectar();
        $sql = "INSERT INTO productos (img, Descripcion, Precio, ID_TipoProducto) VALUES (?, ?, ?, ?)";
        $consulta = $enlace->prepare($sql);

        $consulta->bind_param(
            "ssdi",
            $datos["img"],
            $datos["Descripcion"],
            $datos["Precio"],
            $datos["ID_TipoProducto"]
        );
        
        return $consulta->execute();
    }


    //editar
    public function Editar($datos)
    {
        $enlace = dbConectar();
        $sql = "UPDATE productos SET img=?, Descripcion=?, Precio=?, ID_TipoProducto=? WHERE ID_Producto=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param(
            "ssdii",  // Nota: "ssdii" porque Precio es float y ID_Producto es int
            $datos["img"],
            $datos["Descripcion"],
            $datos["Precio"],
            $datos["ID_TipoProducto"],
            $datos["ID_Producto"]
        );
    
        return $consulta->execute();
    }
    

    public function ObtenerProducto($ID_Producto)
    {
        $enlace = dbConectar();
        $sql = "SELECT * FROM productos WHERE ID_Producto=?";
        $consulta = $enlace->prepare($sql);
        $consulta->bind_param("i", $ID_Producto);
        $consulta->execute();
        $result = $consulta->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }    


    //agregar ingreso
    public function AgregarIngreso($datos) {
        $enlace = dbConectar();
    
        // Insertar en la tabla ingresos
        $sqlIngreso = "INSERT INTO ingresos (ID_Producto, Cantidad, Fecha) VALUES (?, ?, ?)";
        $consultaIngreso = $enlace->prepare($sqlIngreso);
        $consultaIngreso->bind_param("iis", $datos["ID_Producto"], $datos["Cantidad"], $datos["Fecha"]);
        $resultadoIngreso = $consultaIngreso->execute();
    
        if ($resultadoIngreso) {
            // Actualizar la cantidad disponible en la tabla productos
            $sqlActualizar = "UPDATE productos SET Disponible = Disponible + ? WHERE ID_Producto = ?";
            $consultaActualizar = $enlace->prepare($sqlActualizar);
            $consultaActualizar->bind_param("ii", $datos["Cantidad"], $datos["ID_Producto"]);
            return $consultaActualizar->execute();
        }
    
        return false;
    }
    

}
?>