<?php
require_once "config.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);

    session_start(); 
    $_SESSION['id'] = $id; 

    try {
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM " . HALUA_TABLE_NAME . " WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {

                    $row = $result->fetch_assoc();

                    echo "<h1 id='product' class='separate' product_id='" . $id . "'>Informe de producto [ ID-" . $id . " ] <button onclick=\"window.location.href = 'index.php'\">Volver</button></h1>";
                    echo "<div class='splitter'>";

                    echo "<div><form id='form'>";
                    echo "<label for='nombre'>Nombre:</label>";
                    echo "<input type='text' name='nombre' value='" . $row["nombre"] . "' required>";

                    echo "<label for='descripcion'>Descripción:</label>";
                    echo "<input type='text' name='descripcion' value='" . $row['descripcion'] . "' required>";

                    echo "<label for='precio'>Precio (100g):</label>";
                    echo "<input type='number' name='precio' value='" . $row["precio"] . "' required>";

                    echo "<label for='imagen'>Url de la imagen:</label>";
                    echo "<input type='text' name='imagen' value='" . $row["imagen"] . "' required>";

                    echo "<button type='submit'>Actualizar</button>";
                    echo "</form></div>";
                    echo "<div class='details-img'><img class='triggerIMAGG' alt='" . $row['descripcion'] . "' title='" . $row["nombre"] . "' src='" . $row["imagen"] . "'></div>";

                    echo "</div>";
                } else {
                    echo "Error: No se encontró ningún registro con ese ID.";
                }
            } else {
                echo "Error: No se pudo ejecutar la declaración.";
            }
        }

        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn->close();
} else {
    echo "Error: ID no válido.";
}