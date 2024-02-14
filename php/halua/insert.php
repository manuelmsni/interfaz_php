<?php
require_once "../config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $imagen = $_POST["imagen"];
    $descripcion = $_POST["descripcion"];
    try {
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            throw new Exception("Conexión fallida: " . $conn->connect_error);
        }
        $sql = "INSERT INTO " . HALUA_TABLE_NAME . " (nombre, precio, imagen, descripcion) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la sentencia: " . $conn->error);
        }
        $stmt->bind_param("ssss", $nombre, $precio, $imagen, $descripcion);
        if ($stmt->execute() === TRUE) {
            echo "Registro agregado correctamente";
        } else {
            echo "Error al agregar el registro: " . $stmt->error;
        }
        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    } finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
}
?>
