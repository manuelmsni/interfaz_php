<?php
require_once "php/config.php";

// Paso 1: Parámetros de paginación
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = ROWS_PER_PAGE;

try {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Paso 3: Calcular el total de páginas
    $sqlTotal = "SELECT COUNT(*) AS total FROM " . HALUA_TABLE_NAME;
    $resultTotal = $conn->query($sqlTotal);
    $rowTotal = $resultTotal->fetch_assoc();
    $totalPages = ceil($rowTotal['total'] / $recordsPerPage);

    // Verificación para redirigir si el número de página es mayor que el total de páginas
    if ($page > $totalPages && $totalPages > 0) {
        header('Location: ?page=' . $totalPages); // Redirigir a la última página disponible
        exit(); // Asegurar que no se ejecute más código PHP después de la redirección
    } elseif ($page < 1) {
        header('Location: ?page=1'); // Redirigir a la primera página si el número de página es menor que 1
        exit();
    }

    $offset = ($page - 1) * $recordsPerPage; // Calcular el offset después de la posible redirección

    // Paso 2: Consulta para la paginación
    $sql = "SELECT * FROM " . HALUA_TABLE_NAME . " ORDER BY id DESC LIMIT $offset, $recordsPerPage";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr data-id='" . $row["id"] . "'><td>" . $row["nombre"] . "</td><td style='text-align: center'>" . $row["precio"]. "</td><td>" . $row["descripcion"] . "</td><td class='btn-delete' data-id='" . $row["id"] . "'> - </td></tr>";
        }
    } else {
        echo "<tr><td colspan='4'>0 resultados</td></tr>";
    }

} catch (Exception $e) {
    echo "Ocurrió un error: " . $e->getMessage();
    exit();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}

echo '</table>';

echo '<div class="pagination">';
echo '<p>';
// Asegúrate de que la variable $totalPages ya ha sido calculada como se mostró anteriormente
if ($totalPages > 1) {
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "'>&laquo; Anterior</a> ";
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        // Resalta el número de página actual
        if ($i == $page) {
            echo "<a href='?page=$i' style='color: red;'>$i</a> ";
        } else {
            echo "<a href='?page=$i'>$i</a> ";
        }
    }

    if ($page < $totalPages) {
        echo "<a href='?page=" . ($page + 1) . "'>Siguiente &raquo;</a>";
    }
}
echo '</p>';

echo '</div>';
?>