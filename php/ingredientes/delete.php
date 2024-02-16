<?php
require_once "../config.php";
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Asegúrate de que el valor de 'id' esté presente
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Usar sentencias preparadas para prevenir inyecciones SQL
    $query = $conn->prepare("DELETE FROM " . ING_TABLE_NAME . " WHERE id = ?");
    $query->bind_param("i", $id); // 'i' indica que el parámetro es de tipo entero

    if ($query->execute()) {
        echo "Ingrediente eliminado con éxito.";
    } else {
        echo "Error al eliminar ingrediente.";
    }

    $query->close();
} else {
    echo "Error: ID del ingrediente no proporcionado.";
}

$conn->close();

?>