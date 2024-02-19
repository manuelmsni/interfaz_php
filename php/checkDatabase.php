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

    insertarIngrediente(10, "Azúcar glas", 75);
    insertarIngrediente(10, "Agua de azahar", 1);
    insertarIngrediente(10, "Mantequilla clarificada", 15);
    insertarIngrediente(10, "Harina", 250);
    insertarIngrediente(10, "Agua de rosas", 1);
    insertarIngrediente(10, "Agua", 10);

    insertarIngrediente(9, "Azúcar", 280);
    insertarIngrediente(9, "Harina", 1000);
    insertarIngrediente(9, "Pistachos", 100);
    insertarIngrediente(9, "Anis en polvo", 3);
    insertarIngrediente(9, "Avellanas", 200);
    insertarIngrediente(9, "Leche caliente", 30);
    insertarIngrediente(9, "Huevos", 400);
    insertarIngrediente(9, "Agua de azahar", 30);
    insertarIngrediente(9, "Aceite de girasol", 200);
    insertarIngrediente(9, "Agua", 10);
    insertarIngrediente(9, "Almendras", 300);
    insertarIngrediente(9, "Sésamo tostado y triturado", 75);
    insertarIngrediente(9, "Café soluble", 5);
    insertarIngrediente(9, "Levadura química en polvo", 15);
    insertarIngrediente(9, "Nueces", 200);

    insertarIngrediente(8, "Harina extrafina", 400);
    insertarIngrediente(8, "Harina de todo uso", 300);
    insertarIngrediente(8, "Azúcar glas", 200);
    insertarIngrediente(8, "Lavadura química", 10);
    insertarIngrediente(8, "Leche", 50);
    insertarIngrediente(8, "Agua de azahar", 60);
    insertarIngrediente(8, "Dátiles", 250);
    insertarIngrediente(8, "Nueces", 30);
    insertarIngrediente(8, "Pistachos", 50);
    insertarIngrediente(8, "Almendras", 30);

    insertarIngrediente(7, "Sémola de trigo", 350);
    insertarIngrediente(7, "Datiles", 100);
    insertarIngrediente(7, "Azúcar", 200);
    insertarIngrediente(7, "Canela molida", 5);
    insertarIngrediente(7, "Azafrán molido", 1);
    insertarIngrediente(7, "Aceite de oliva", 4);
    insertarIngrediente(7, "Zumo de limón", 40);
    insertarIngrediente(7, "Agua de azahar", 10);
    insertarIngrediente(7, "Agua templada", 200);

    insertarIngrediente(6, "Pistachos ", 250);
    insertarIngrediente(6, "Azúcar", 200);
    insertarIngrediente(6, "Canela", 5);
    insertarIngrediente(6, "Mantequilla", 150);
    insertarIngrediente(6, "Pasta filo", 250);
    insertarIngrediente(6, "Agua", 200);
    insertarIngrediente(6, "Rlladura de limón", 4);

    insertarIngrediente(5, "Harina", 400);
    insertarIngrediente(5, "Azúcar", 120);
    insertarIngrediente(5, "Almendras peladas y molidas", 300);
    insertarIngrediente(5, "Canela en polvo", 5);
    insertarIngrediente(5, "Mantequilla", 5);
    insertarIngrediente(5, "Agua de azahar", 40);

    insertarIngrediente(4, "Aceite vegetal", 210);
    insertarIngrediente(4, "Huevos", 130);
    insertarIngrediente(4, "Azúcar", 200);
    insertarIngrediente(4, "Vainilla liquida", 6);
    insertarIngrediente(4, "Harina", 400);
    insertarIngrediente(4, "Levadura en polvo", 10);
    insertarIngrediente(4, "Mermelada de Albaricoque", 625);
    insertarIngrediente(4, "Agua de azahar", 20);
    insertarIngrediente(4, "Coco rallado", 200);

    insertarIngrediente(3, "Harina", 500);
    insertarIngrediente(3, "Aceie de oliva", 25);
    insertarIngrediente(3, "Huevo", 130);
    insertarIngrediente(3, "Mantequilla", 80);
    insertarIngrediente(3, "Almendras", 200);
    insertarIngrediente(3, "Pistachos", 100);
    insertarIngrediente(3, "Azúcar", 200);
    insertarIngrediente(3, "Canela", 12);
    insertarIngrediente(3, "Agua de azahar", 12);
    insertarIngrediente(3, "Jengibre en polvo", 5);

    insertarIngrediente(2, "Harina de almendra", 500);
    insertarIngrediente(2, "Azúcar glass", 200);
    insertarIngrediente(2, "Mantequilla", 30);
    insertarIngrediente(2, "Huevos", 130);
    insertarIngrediente(2, "Levadura en polvo", 10);
    insertarIngrediente(2, "Agua de azahar", 20);
    insertarIngrediente(2, "Ralladura de limón", 5);
    insertarIngrediente(2, "Mermelada de albaricoque", 15);
    insertarIngrediente(2, "Harina de trigo", 1);

    insertarIngrediente(1, "Harina", 400);
    insertarIngrediente(1, "Aceite de oliva", 30);
    insertarIngrediente(1, "Mantequilla", 15);
    insertarIngrediente(1, "Sal", 5);
    insertarIngrediente(1, "Azafrán", 1);
    insertarIngrediente(1, "Agua de azahar", 10);
    insertarIngrediente(1, "Canela en polvo", 5);
    insertarIngrediente(1, "Azucar glas", 15);
    insertarIngrediente(1, "Anís en polvo", 5);
    insertarIngrediente(1, "Semillas de sésamo trituradas", 100);
    insertarIngrediente(1, "Almendras tostadas en polvo", 10);
    insertarIngrediente(1, "levadura en polvo", 5);
    insertarIngrediente(1, "Aceite de girasol", 200);
    insertarIngrediente(1, "Miel", 200);


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
        //showMessage("Dulce $nombre insertado correctamente.");
    } else {
        showMessage("Error al insertar el dulce $nombre: " . $stmt->error );
    }

    $stmt->close();
    $conn->close();
}

function insertarIngrediente($halua_id, $nombre, $cantidad) {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO " . ING_TABLE_NAME . " (halua_id, nombre, cantidad) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error );
    }

    $stmt->bind_param("isi", $halua_id, $nombre, $cantidad); // Cambio "ssss" a "isi" para representar entero, cadena, entero

    if ($stmt->execute()) {
        //echo("Ingrediente $nombre del producto $halua_id insertado correctamente.");
    } else {
        echo("Error al insertar el dulce $nombre: " . $stmt->error );
    }

    $stmt->close();
    $conn->close();
}
function showMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}

checkDatabaseAndTables();


