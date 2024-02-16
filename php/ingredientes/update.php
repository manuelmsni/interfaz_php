<?php

require_once "../config.php";

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'] ?? null;
$ingrediente = $_POST['nombre'] ?? null;
$cantidad = $_POST['cantidad'] ?? null;

if ($ingrediente == null || $id == null || $cantidad == null) {
    die("Campos nulos");
}

$query = "UPDATE ". ING_TABLE_NAME ." SET nombre = ?, cantidad = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $ingrediente, $cantidad, $id); // Correctly assigns types for each variable
$stmt->execute();

if ($stmt->error) {
    echo "Error updating record: " . $stmt->error;
} else {
    echo "Ingrediente actualizado con éxito.";
}
$stmt->close();
?>