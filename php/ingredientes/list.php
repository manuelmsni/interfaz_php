<?php
require_once 'conexion.php';
require_once "php/config.php";

// Obtener halua_id de la URL
if(isset($_GET['id'])) {
    $halua_id = $_GET['id'];
} else {
    // Manejar el caso en que no se proporciona halua_id en la URL
    echo "Error: No se proporcionó halua_id en la URL.";
    exit; // Terminar el script
}
$query = "SELECT * FROM " . ING_TABLE_NAME . " WHERE halua_id = " . $halua_id;

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<script type='text/javascript'>agregarFila('".$row['nombre']."', ".$row['cantidad'].", ". $row['id'].");</script>";
}

?>