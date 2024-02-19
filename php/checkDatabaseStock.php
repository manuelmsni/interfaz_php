<?php

require_once "config.php";

function checkDatabaseAndTables() {
    try {
        $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!tableExists($mysqli, HALUA_TABLE_NAME_STOCK)) {
            showMessage("La tabla no existe. Intentando crearla...");
            createTables();
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1049) {
            showMessage("La base de datos no existe. Intentando crearla...");
            createDatabase();
        } else if ($e->getCode() == 2002) {
            showMessage("No se puede establecer conexión con el servidor MySQL. Verifica tus configuraciones.");
        } else {
            showMessage("Error de conexión:");
        }
    }
}
function tableExists($mysqli, $tableName) {
    $checkTable = $mysqli->query("SHOW TABLES LIKE '".$tableName."'");
    return $checkTable && $checkTable->num_rows > 0;
}
function createDatabase() {

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if ($conn->connect_error) {
        die("<p>No se puede conectar con el servidor de la base de datos</p");
    }

    $sql = "CREATE DATABASE " . DB_NAME;

    if ($conn->query($sql) === TRUE) {
        createTables();
    } else {
        die();
    }

    $conn->close();
}
function createTables()
{
    try{
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "CREATE TABLE " . HALUA_TABLE_NAME_STOCK . " (
            id_stock INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL,
            cantidad_stock INT NOT NULL,
            fecha_produccion DATE NOT NULL,
            id INT,
            FOREIGN KEY (id) REFERENCES halua(id)
        );

        INSERT INTO " . HALUA_TABLE_NAME_STOCK . " (nombre, cantidad_stock, fecha_produccion, id)
        VALUES
        ('Kwirat Tlj', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Kwirat Tlj')),
        ('Briwat', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Briwat')),
        ('Ghriba', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Ghriba')),
        ('Chebakia', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Chebakia')),
        ('Mhencha', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Mhencha')),
        ('Feqqas', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Feqqas')),
        ('Maamoul', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Maamoul')),
        ('Makrout', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Makrout')),
        ('Baklava', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Baklava')),
        ('Kaab ghzal', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Kaab ghzal'));";
        if ($conn->query($sql) === TRUE) {
            showMessage("Se ha creado la tabla " . HALUA_TABLE_NAME_STOCK );
        } else {
            showMessage("No se ha podido crear la tabla " . HALUA_TABLE_NAME_STOCK );
        }
    } catch (Exception $e) {
        showMessage("Error: " . $e->getMessage());
    } finally {
        if (isset($conn)) {
            $conn->close();
        }
    }




}

function actualizarStockEnBD($productoId, $nuevaCantidad) {
   
    
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

   
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

   
    $productoId = $conn->real_escape_string($productoId);
    $nuevaCantidad = $conn->real_escape_string($nuevaCantidad);

  
    $sql = "UPDATE halua_stock SET cantidad_stock = '$nuevaCantidad' WHERE id = '$productoId'";

  
    if ($conn->query($sql) === TRUE) {
        echo "Stock actualizado con éxito";
    } else {
        echo "Error al actualizar el stock: " . $conn->error;
    }

   
    $conn->close();
}

function insertarDulce($nombre, $cantidad, $fecha_produccion) {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO " . HALUA_TABLE_NAME_STOCK . " (nombre, cantidad, fecha_produccion) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error );
    }

    $stmt->bind_param("ssss", $nombre, $cantidad, $fecha_produccion);

    if ($stmt->execute()) {
        
    } else {
        showMessage("Error al insertar el dulce $nombre: " . $stmt->error );
    }

    $stmt->close();
    $conn->close();
}



function showMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}

checkDatabaseAndTables();


