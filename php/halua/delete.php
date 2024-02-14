<?php
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            throw new Exception("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "DELETE FROM " . HALUA_TABLE_NAME . " WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Registro eliminado con éxito";
        } else {
            echo "Error al eliminar el registro";
        }
    } catch (Exception $e) {
        exit();
    } finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
} else {
    echo "ID no proporcionado";
}