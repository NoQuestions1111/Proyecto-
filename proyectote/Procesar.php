<?php
session_start(); // Para manejar los datos persistentes

if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['eliminar'])) {
        // Elimina un producto usando el índice
        $indice = $_POST['eliminar'];
        unset($_SESSION['productos'][$indice]);
    } else {
        // Agregar un producto nuevo
        $clave = $_POST['txtid'];
        $nombre = $_POST['txtnombre'];
        $precio = $_POST['txtprecio'];
        $cantidad = $_POST['txtcantidad'];

        $imagePath = './images/default.jpg';
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $imagePath = $uploadDir . basename($_FILES['imagen']['name']);
            move_uploaded_file($_FILES['imagen']['tmp_name'], $imagePath);
        }

        $producto = [
            'clave' => $clave,
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'imagen' => $imagePath,
        ];

        $_SESSION['productos'][] = $producto;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Almacenados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
            padding: 20px;
            background: linear-gradient(to right, #f1e1a6, #f7a6c7);
            color: white;
        }
        .card img {
            height: 250px;
            width: 250px;
            object-fit: cover;
            border-radius: 50%;
            margin: 20px auto;
            display: block;
        }
        .card-body {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Productos Almacenados</h1>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php if (!empty($_SESSION['productos'])): ?>
                <?php foreach ($_SESSION['productos'] as $index => $producto): ?>
                    <div class="col-6 col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" alt="Producto">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                                <p class="card-text">
                                    Precio: $<?= number_format($producto['precio'], 2) ?><br>
                                    Cantidad: <?= htmlspecialchars($producto['cantidad']) ?>
                                </p>
                                <form method="post">
                                    <button type="submit" name="eliminar" value="<?= $index ?>" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-muted">No hay productos registrados aún.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
