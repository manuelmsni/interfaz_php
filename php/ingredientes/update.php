<?php
require_once 'conexion.php';
require_once "php/config.php";

$id = $_POST['id'];
$ingrediente = $_POST['ingrediente'];
$cantidad = $_POST['cantidad'];

$query = "UPDATE  ". ING_TABLE_NAME ."  SET ingrediente = '$ingrediente', cantidad = $cantidad WHERE id = $id";
mysqli_query($conn, $query);

echo "Ingrediente actualizado con éxito.";
?>