<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe</title>
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/background.css">
    <link rel="stylesheet" href="https://manuelmsni.github.io/IMAGG/css/IMAGG_default.css">
</head>
<body>
<div class="container">

        <?php include 'php/detalle.php'; ?>

</div>

<div class="container">

    <h2>Ingredientes</h2>
    <div>
        <form id="ing">
            <table>
                <thead>
                <th>Ingrediente</th>
                <th>Cantidad (g)</th>
                <th style="width: 0;min-width: fit-content;white-space: nowrap;text-align: center"><button type="button" onclick="agregarFila()"> + </button></th>
                </thead>
                <tbody id="ing-list">
                </tbody>
            </table>
            <button style="margin-top:1rem;" type="submit">Actualizar</button>
        </form>
    </div>

</div>
<script>
    document.getElementById('form').addEventListener('submit', function(e) {
        e.preventDefault();
        var datosFormulario = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/halua/update.php', true);
        xhr.onload = function() {
            if (this.status === 200) {
                console.log(this.responseText);
                location.reload();
            }
        };

        xhr.send(datosFormulario);
    });
</script>

<script>
    function agregarFila() {
        var table = document.getElementById("ing-list");
        var row = table.insertRow(-1); // Inserta una fila al final de la tabla
        var cell1 = row.insertCell(0); // Inserta la primera celda en la fila
        var cell2 = row.insertCell(1); // Inserta la segunda celda en la fila
        var cell3 = row.insertCell(2); // Inserta la tercera celda para el botón de eliminar

        // Crea un input para la primera celda
        var input1 = document.createElement("input");
        input1.type = "text";
        cell1.appendChild(input1);

        // Crea un input para la segunda celda
        var input2 = document.createElement("input");
        input2.type = "number";
        cell2.appendChild(input2);

        cell3.innerHTML = " - ";
        cell3.className = "btn-delete";
        cell3.style.cursor = "pointer"; // Cambia el cursor para indicar que es clickeable
        cell3.onclick = function() {
            // Encuentra la fila (<tr>) que contiene esta celda (<td>)
            var row = this.parentNode; // 'this' se refiere a la celda (<td>), parentNode sería el <tr>

            // Usa parentNode para encontrar el <tbody> o <table> que contiene la fila y luego eliminar la fila
            row.parentNode.removeChild(row); // Elimina directamente la fila entera
        };
    }

</script>
<script src="https://manuelmsni.github.io/IMAGG/IMAGG_1.0/js/IMAGG.js"></script>
</body>
</html>