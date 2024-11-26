<form action="Procesar2.php"method="POST" enctype="multipart/form-data">

<label>Nombre del Producto:</label><br>
<input type="text" name="txtproducto" requerided><br>

<label>Precio:</label><br>
<input type="number" name="txtprecio" step="0.1" requerided><br><br>

<label>Cantidad:</label><br>
<input type="number" name="txtcantidad" requerided><br><br>

<label>Subir Imagen:</label>
<input type="file" name="imagen" requerided>
<br><br><br>

<input type="submit" name="enviar" value="Enviar"><br><br>

</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen'])) {

    $producto = $_POST['txtproducto'];
    $precio = $_POST['txtprecio'];
    $cantidad = $_POST['txtcantidad'];
    $total = $cantidad * $precio;
    $imagen = file_get_contents($_FILES['imagen']['tmp_name']);

    echo "Nombre: " . $producto . "<br>";
    echo "Precio: " . $precio . "<br>";
    echo "Cantidad: " . $cantidad . "<br>";
    echo "Total: " . $total . "<br>";
    $imagen = file_get_contents($_FILES['imagen']['tmp_name']);

    
    $host = '127.0.0.1';
    $username = 'root';
    $password = '';
    $db_name = 'proyecto_maestra';
    $tbl_name = 'Productos';


    $conexion = new mysqli($host, $username, $password, $db_name);

    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    } else {
        echo "Conexión exitosa" ".""<br>";
    }


    $consulta1 = $conexion->prepare("INSERT INTO Productos (Producto, Precio, Cantidad, Total, Imagen) VALUES (?, ?, ?, ?, ?)");
    $consulta1->bind_param("sssss", $producto, $precio, $cantidad, $total, $imagen);
}

if ($consultal->execute()) {
    echo "El producto se dio de alta correctamente.";
} else {
    echo "Error al dar de alta el producto: " . $consultal->error;
}

$consultal->close();


echo "<h1>Listado de venta de Productos </h1>";
$consultal2 = $conexion->prepare("SELECT * FROM Productos");
$resultados = $conexion->query($consultal2);


echo "<table border='2'>";
echo "<tr>";
echo "<th>Clave</th>";
echo "<th>Producto</th>";
echo "<th>Precio</th>";
echo "<th>Cantidad</th>";
echo "<th>Total</th>";
echo "<th>Imagen</th>";
echo "</tr>";


while ($fila = $resultados->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $fila['idproducto'] . "</td>";
    echo "<td>" . $fila['Producto'] . "</td>";
    echo "<td>" . $fila['Precio'] . "</td>";
    echo "<td>" . $fila['Cantidad'] . "</td>";
    echo "<td>" . $fila['Total'] . "</td>";
    echo "<td><img src='data:imagenes/image/jpg; base64," . base64_encode($fila['Imagen']) . "' width='100'></td>";
    echo "</tr>";
}

echo "</table>";

?>
