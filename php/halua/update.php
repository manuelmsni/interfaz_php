<?php
require_once "../config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $id = $_SESSION['id'];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $imagen = $_POST["imagen"];
    $descripcion = $_POST["descripcion"];
    try {
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            throw new Exception("Conexión fallida: " . $conn->connect_error);
        }
        $sql = "UPDATE " . HALUA_TABLE_NAME . " SET nombre = ?, precio = ?, imagen = ?, descripcion = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la sentencia: " . $conn->error);
        }
        $stmt->bind_param("ssssi", $nombre, $precio, $imagen, $descripcion, $id);
        if ($stmt->execute() === TRUE) {
            echo "Registro actualizado correctamente";
        } else {
            echo "Error al actualizar el registro: " . $stmt->error;
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