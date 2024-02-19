
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Ventas</title>
    <link rel="stylesheet" href="assets/styles/styles_ventas.css">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/background.css">
    <?php include 'php/halua/lista_halua_para_ventas.php'?>
</head>
<header>
    
    <?php include 'php/checkDatabaseStock.php'; ?>
    <h1>Ventas</h1>
    <h2> Dulces marroquíes Tarik y Manuel </h2>
</header>

<body>
    <h1>Tabla de Ventas</h1>
    
    <?php
    require_once "php/config.php";
    
    $productos = obtenerProductosDesdeBD();
    
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['vender'])) {
        
        foreach ($_POST['cantidad'] as $nombreProducto => $cantidadVenta) {
            
            realizarVenta($nombreProducto, $cantidadVenta);
        }
    
        
        
    }
    ?>

    <form method="post" action="">
        <table>
            <thead>
                <tr>
                    <th>Nombre del producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php $productos = obtenerProductosDesdeBD(); foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['precio']; ?> €</td>
                        <td><?php echo $producto['cantidad_stock']; ?> unidades</td>
                        <td>
                            <input type="number" name="cantidad[<?php echo $producto['nombre']; ?>]" value="0" min="0" max="<?php echo $producto['cantidad_stock']; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <style>
   
    input[name="vender"] {
        width: 1900px; 
        height: 50px; 
        font-size: 25px;
       }
</style>
        <input type="submit" name="vender" value="Vender">
    </form>

    <?php
   
   $precioTotal = 0;
   
   foreach ($productos as $producto) {
       $nombreProducto = $producto['nombre'];
   
       $cantidadVenta = !empty($_POST['cantidad'][$nombreProducto]) ? $_POST['cantidad'][$nombreProducto] : 0;
   
       if (is_numeric($cantidadVenta)) {
           $precioTotal += $producto['precio'] * $cantidadVenta;
       }
   }
    ?>

<div id="total-precio">
    <h3>Precio Total: <?php echo $precioTotal; ?> €</h3>
</div>


<button id="actualizarTotalBtn">Actualizar Total</button>



    <footer>
        <p>&copy; 2024 dulces marroquíes Tarik y Manuel</p>
    </footer>
</body>
</html>


<!--

INSERT INTO halua_stock (nombre, cantidad_stock, fecha_produccion, id)
VALUES
('Kwirat Tlj', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Kwirat Tlj')),
('Briwat', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Briwat')),
('Ghriba', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Ghriba')),
('Chebakia', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Chebakia')),
('Mhencha', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Mhencha')),
('Feqqas', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Feqqas')),
('Maamoul', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Maamoul')),
('Makrout', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Makrout')),
('Baklava', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Baklava')),
('Kaab ghzal', 100, CURDATE(), (SELECT id FROM halua WHERE nombre = 'Kaab ghzal'));

 -->