<?php
require_once "../config.php";

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$ingrediente = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$halua_id = $_POST['halua_id'];

$query = "INSERT INTO ". ING_TABLE_NAME ." (ingrediente, cantidad, halua_id) VALUES ('$ingrediente', $cantidad, $halua_id)";
mysqli_query($conn, $query);

echo "Ingrediente agregado con éxito.";
?>