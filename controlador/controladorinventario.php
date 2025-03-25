<?php
include_once("../config.php");

if (isset($_POST["ope"])) {
    $ope = $_POST["ope"];
    include_once("../modelos/inventario.php");
    $pro = new inventario();

    if ($ope == "LISTAPRODUCTOS") {
        $lista = $pro->ListarPRODUCTOS();
        $info = array("success" => true, "lista" => $lista);
        echo json_encode($info);
    }

    //nuevo producto
    elseif ($ope == "AGREGAR" && isset($_POST["Descripcion"], $_POST["Precio"], $_POST["ID_TipoProducto"])) {
       
        if (!empty($_FILES["img"]["name"])) {
            $directorio = "../inventarioimg/"; // Carpeta imágenes
            $nombreArchivo = time() . "_" . basename($_FILES["img"]["name"]);
            $rutaFinal = $directorio . $nombreArchivo;

            // Mueve la imagen
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $rutaFinal)) {
                $rutaBD = "inventarioimg/" . $nombreArchivo;
            } else {
                echo json_encode(array("success" => false, "msg" => "Error al subir la imagen"));
                exit;
            }
        } else {
            $rutaBD = "inventarioimg/default.png";
        }

        // Datos a guardar en la BD
        $datos = array(
            "img" => $rutaBD,
            "Descripcion" => $_POST["Descripcion"],
            "Precio" => $_POST["Precio"],
            "ID_TipoProducto" => $_POST["ID_TipoProducto"]
        );

        $status = $pro->Agregar($datos);
        echo json_encode(array("success" => $status));
    }

    //  obtener 
    elseif ($ope == "OBTENER") {
        if (isset($_POST["ID_Producto"])) {
            $producto = $pro->ObtenerProducto($_POST["ID_Producto"]);
            if ($producto) {
                echo json_encode(["success" => true, "producto" => $producto]);
            } else {
                echo json_encode(["success" => false, "msg" => "producto no encontrado."]);
            }
        } else {
            echo json_encode(["success" => false, "msg" => "ID del producto no proporcionado."]);
        }
    }

    // editar  producto
    elseif ($ope == "EDITAR" && isset($_POST["ID_Producto"], $_POST["imge"], $_POST["Descripcione"], $_POST["precioe"], $_POST["ID_TipoProductoe"])) {
        $datos = array(
            "ID_Producto" => $_POST["ID_Producto"],
            "img" => $_POST["imge"],
            "Descripcion" => $_POST["Descripcione"],
            "Precio" => $_POST["precioe"],
            "ID_TipoProducto" => $_POST["ID_TipoProductoe"]
        );
    
        $status = $pro->Editar($datos);
        echo json_encode(array("success" => $status));
    }
    

    //agregar ingreso
    elseif ($ope == "AGREGAR_INGRESO" && isset($_POST["ID_Producto"], $_POST["Cantidad"], $_POST["Fecha"])) {
        $datos = array(
            "ID_Producto" => $_POST["ID_Producto"],
            "Cantidad" => $_POST["Cantidad"],
            "Fecha" => $_POST["Fecha"]
        );
    
        $status = $pro->AgregarIngreso($datos);
        echo json_encode(array("success" => $status));
    }    

    else {
        echo json_encode(array("success" => false, "msg" => "Operación no válida o parámetros insuficientes"));
    }
}
?>

