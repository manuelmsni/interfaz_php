<?php
require_once 'conexion.php';
require_once "php/config.php";

$ingrediente = $_POST['ingrediente'];
$cantidad = $_POST['cantidad'];

$query = "INSERT INTO ". ING_TABLE_NAME ." (ingrediente, cantidad) VALUES ('$ingrediente', $cantidad)";
mysqli_query($conn, $query);

echo "Ingrediente agregado con éxito.";
?>