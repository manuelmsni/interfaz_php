<?php
require_once 'conexion.php';
require_once "..p/config.php";
$id = $_POST['id'];

$query = "DELETE FROM  ". ING_TABLE_NAME ."  WHERE id = $id";
mysqli_query($conn, $query);

echo "Ingrediente eliminado con éxito.";
?>