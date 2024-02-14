<?php
require_once "config.php";

function checkDatabaseAndTables() {
    try {
        $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!tableExists($mysqli, HALUA_TABLE_NAME)) {
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

        $sql = "CREATE TABLE ". HALUA_TABLE_NAME . " ( id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(50) NOT NULL, precio VARCHAR(50) NOT NULL, imagen VARCHAR(250), descripcion VARCHAR(250))";

        if ($conn->query($sql) === TRUE) {
            showMessage("Se ha creado la tabla " . HALUA_TABLE_NAME );
        } else {
            showMessage("No se ha podido crear la tabla " . HALUA_TABLE_NAME );
        }

        $sql = "CREATE TABLE ". ING_TABLE_NAME . " ( id INT AUTO_INCREMENT PRIMARY KEY, halua_id INT ,nombre VARCHAR(50) NOT NULL, cantidad INT NOT NULL, FOREIGN KEY (halua_id) REFERENCES " . HALUA_TABLE_NAME . "(id) ON DELETE CASCADE)";

        if ($conn->query($sql) === TRUE) {
            showMessage("Se ha creado la tabla " . ING_TABLE_NAME );
        } else {
            showMessage("No se ha podido crear la tabla " . ING_TABLE_NAME );
        }
    } catch (Exception $e) {
        showMessage("Error: " . $e->getMessage());
    } finally {
        if (isset($conn)) {
            $conn->close();
        }
    }

    insertarDulce("Chebakia", 6, "https://upload.wikimedia.org/wikipedia/commons/4/44/Shebbaqu%C3%ADas.jpg", "Masa de pastas frita y sumergida en miel.");
    insertarDulce("Ghriba", 4, "https://marruecoshoy.com/wp-content/uploads/2021/09/ghriba.png", "Galletas de almendra suaves y blandas.");
    insertarDulce("Briwat", 5, "https://marruecoshoy.com/wp-content/uploads/2021/09/briwat-1024x682.jpeg", "Pastel pequeño, triangular, frito, endulzado con miel y relleno de almendras");
    insertarDulce("Kwirat Tlj", 8, "https://marruecoshoy.com/wp-content/uploads/2021/09/bolitas-coco.png", "Galletas de vainilla con mermelada de albaricoque perfumada con agua de azahar y cubiertas de coco.");
    insertarDulce("kaab ghzal", 9, "https://www.visitmorocco.com/sites/default/files/cornes-de-gazelle.jpg", "Pasta rellenas de dátiles, su masa es suave y quebradiza. Tiene un intenso aroma a azahar.");
    insertarDulce("Baklava", 7, "https://marruecoshoy.com/wp-content/uploads/2021/09/baklava-marroqui.webp", "Dulce de hojaldre relleno de frutos secos y bañado en miel.");
    insertarDulce("Makrout", 5, "https://marruecoshoy.com/wp-content/uploads/2021/09/makrout.jpeg", "Dulce de dátiles y harina de trigo.");
    insertarDulce("Maamoul", 4, "https://marruecoshoy.com/wp-content/uploads/2021/09/maamoul.jpeg", "Pastel de hojaldre relleno de dátiles y aromatizado con agua de azahar y canela");
    insertarDulce("Feqqas", 6, "https://marruecoshoy.com/wp-content/uploads/2021/09/feqqas-1024x576.jpeg", "Galletas de almendra y semillas de sésamo, a menudo se aromatiza con vainilla.");
    insertarDulce("Mhencha", 7, "https://marruecoshoy.com/wp-content/uploads/2021/09/mhencha-1024x1024.jpeg", "Pasta de almendras metida en una hoja de filo (warqa), enrrollada y sumergida en miel a fuego lento.");
}



function insertarDulce($nombre, $precio, $imagen, $descripcion) {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO " . HALUA_TABLE_NAME . " (nombre, precio, imagen, descripcion) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error );
    }

    $stmt->bind_param("ssss", $nombre, $precio, $imagen, $descripcion);

    if ($stmt->execute()) {
        showMessage("Dulce $nombre insertado correctamente.");
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


