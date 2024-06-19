<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú del Restaurante</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <body background="https://static.vecteezy.com/system/resources/previews/000/429/077/original/vector-seamless-restaurant-menu-pattern-background.jpg" width=50 height=50 ALIGN="center "></body>
    <h1><p align="center"><font face = "Georgia"><marquee><I>-RESTAURANTE JARDIN DE SABORES-</I></marquee></font></p></h1>
    <a href="insertar_plato.php" class="button">Insertar Nuevo Plato</a>
    <?php
    include 'conexion.php';
    $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.imagen, c.nombre AS categoria 
            FROM platos p 
            JOIN categorias c ON p.categoria_id = c.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='plato'>";
            echo "<h2>" . $row['nombre'] . "</h2>";
            echo "<img src='imagenes/" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>";
            echo "<p>" . $row['descripcion'] . "</p>";
            echo "<p>Precio: $" . $row['precio'] . "</p>";
            echo "<p>Categoría: " . $row['categoria'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "No hay platos disponibles";
    }

    $conn->close();
    ?>
</body>
</html>
