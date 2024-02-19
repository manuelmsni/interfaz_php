<?php
require_once "php/config.php";
function obtenerProductosDesdeBD() {
    $productos = array();
    
   
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

   
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    
    $sql = "SELECT halua.nombre, halua.precio, halua_stock.cantidad_stock
        FROM " . HALUA_TABLE_NAME . "
        JOIN halua_stock ON halua.id = halua_stock.id;";
   
    $result = $conn->query($sql);

    
    if ($result) {
      
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }

        
        $result->free_result();
        $conn->close();
    } else {
        die("Error en la consulta SQL: " . $conn->error);
    }

    return $productos;
}
function realizarVenta($nombreProducto, $cantidadVenta) {
    
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

   
    $conn->begin_transaction();

    try {
        
        $sqlStock = "SELECT cantidad_stock FROM halua_stock WHERE nombre = ?";
        $stmtStock = $conn->prepare($sqlStock);
        $stmtStock->bind_param("s", $nombreProducto);
        $stmtStock->execute();
        $stmtStock->bind_result($stockActual);
        $stmtStock->fetch();
        $stmtStock->close();

       
        if ($stockActual >= $cantidadVenta) {
        
            $nuevoStock = $stockActual - $cantidadVenta;
            $sqlUpdateStock = "UPDATE halua_stock SET cantidad_stock = ? WHERE nombre = ?";
            $stmtUpdateStock = $conn->prepare($sqlUpdateStock);
            $stmtUpdateStock->bind_param("is", $nuevoStock, $nombreProducto);
            $stmtUpdateStock->execute();
            $stmtUpdateStock->close();

            
           

           
            $conn->commit();
        } else {
            
            echo "No hay suficiente stock para realizar la venta.";
           
            $conn->rollback();
        }
    } catch (Exception $e) {
        
        echo "Error al realizar la venta: " . $e->getMessage();
        $conn->rollback();
    }

   
    $conn->close();
}


?>