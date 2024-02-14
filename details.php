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

    <script>
        toDelete = new Array();
        toAdd = new Array();
        toUpdate = new Array();
        function agregarFila(ingrediente, cantidad, id) {
            var table = document.getElementById("ing-list");
            var row = table.insertRow(-1);

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            var input1 = document.createElement("input");
            input1.type = "text";
            if(ingrediente) input1.value = ingrediente;

            cell1.appendChild(input1);

            var input2 = document.createElement("input");
            input2.type = "number";
            if(cantidad) input2.value = cantidad;

            cell2.appendChild(input2);

            if(id) {
                row.setAttribute("id_ing", id);
                row.setAttribute("changed", "false");
                input1.onchange = function() {
                    var row = this.parentNode.parentNode;
                    if(row.getAttribute("changed") === "false"){
                        row.setAttribute("changed", "true");
                        toUpdate.push(row);
                    }
                };
                input2.onchange = function() {
                    var row = this.parentNode.parentNode;
                    if(row.getAttribute("changed") === "false"){
                        row.setAttribute("changed", "true");
                        toUpdate.push(row);
                    }
                };
            } else toAdd.push(row);
            cell3.innerHTML = " - ";
            cell3.className = "btn-delete";
            cell3.style.cursor = "pointer";
            cell3.onclick = function() {
                var row = this.parentNode;
                toDelete.push(row.getAttribute("id_ing"));
                row.parentNode.removeChild(row);
            };
        }

    </script>

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
                    <?php include 'php/ingredientes/list.php'; ?>
                </tbody>
            </table>
            <button style="margin-top:1rem;" type="submit">Actualizar</button>
        </form>
    </div>

    <script>
        agregarFila("harina", 200, 2);
    </script>

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
    document.getElementById('ing').addEventListener('submit', function(e) {
        e.preventDefault();
        toDelete.forEach(id => {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/ingredientes/delete.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    console.log(this.responseText);
                }
            };
            xhr.send("id=" + id);
        });
        toAdd.forEach(row => {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/ingredientes/insert.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    console.log(this.responseText);
                }
            };
            xhr.send("ingrediente=" + row.cells[0].children[0].value + "&cantidad=" + row.cells[1].children[0].value);
        });
        toUpdate.forEach(row => {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/ingredientes/update.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    console.log(this.responseText);
                }
            };
            xhr.send("id=" + row.getAttribute("id_ing") + "&ingrediente=" + row.cells[0].children[0].value + "&cantidad=" + row.cells[1].children[0].value);
        });
    });
</script>


<script src="https://manuelmsni.github.io/IMAGG/IMAGG_1.0/js/IMAGG.js"></script>
</body>
</html>