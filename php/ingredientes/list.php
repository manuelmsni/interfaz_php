<?php
require_once 'conexion.php';
require_once "php/config.php";

$query = "SELECT id, nombre, cantidad FROM  ". ING_TABLE_NAME;
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr id_ing='" . $row['id'] . "' changed='false'>";
    echo "<td>" . $row['ingrediente'] . "</td>";
    echo "<td>" . $row['cantidad'] . "</td>";
    echo "<td class='btn-delete' style='cursor:pointer;' onclick='eliminarFila(this)'> - </td>";
    echo "</tr>";
}
?>