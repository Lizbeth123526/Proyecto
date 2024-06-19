<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Plato</title>
    <link rel="stylesheet" href="style.css">
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var categoriaSelect = document.getElementById("categoria");
            var nuevaCategoriaDiv = document.getElementById("nuevaCategoria");
            var nuevaCategoriaInput = document.getElementById("nueva_categoria");

            categoriaSelect.addEventListener("change", function() {
                if (categoriaSelect.value === "nueva") {
                    nuevaCategoriaDiv.style.display = "block";
                    nuevaCategoriaInput.required = true;
                } else {
                    nuevaCategoriaDiv.style.display = "none";
                    nuevaCategoriaInput.required = false;
                }
            });
        });
    </script>
</head>
<body>
<h1><p align="center"><font face = "Bodoni MT Black"><I>-Ingrese nuevo platillo-</I></font></p></h1>
    <form action="insertar_plato.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre del Platillo o Bebida:</label><br>
        <input type="text" id="nombre" name="nombre" required><br>
        
        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" required></textarea><br>
        
        <label for="precio">Precio:</label><br>
        <input type="number" id="precio" name="precio" step="0.01" required><br>
        
        <label for="categoria">Categoría:</label><br>
        <select id="categoria" name="categoria" required>
            <option value="" disabled selected>Selecciona una categoría o ingresa una nueva</option>
            <?php
            include 'conexion.php';
            $sql = "SELECT * FROM categorias";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
            }
            ?>
            <option value="nueva">Agregar nueva categoría</option>
        </select><br>

        <div id="nuevaCategoria" style="display: none;">
            <label for="nueva_categoria">Nueva Categoría:</label><br>
            <input type="text" id="nueva_categoria" name="nueva_categoria"><br>
        </div>
        
        <label for="imagen">Imagen:</label><br>
        <input type="file" id="imagen" name="imagen" accept="image/*" required><br><br>
        
        <input type="submit" value="Insertar Plato">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $imagen = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $imagen_folder = "imagenes/" . $imagen;
        move_uploaded_file($imagen_temp, $imagen_folder);

        $categoria_id = $_POST['categoria'];
        if ($categoria_id == "nueva") {
            // Insertar nueva categoría en la base de datos
            $nueva_categoria = $_POST['nueva_categoria'];
            $sql = "INSERT INTO categorias (nombre) VALUES ('$nueva_categoria')";
            if ($conn->query($sql) === TRUE) {
                $categoria_id = $conn->insert_id; // Obtener el ID de la nueva categoría
            } else {
                echo "Error al insertar nueva categoría: " . $conn->error;
            }
        }

        // Insertar el nuevo plato con la categoría seleccionada o nueva
        $sql = "INSERT INTO platos (nombre, descripcion, precio, imagen, categoria_id) 
                VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$categoria_id')";

        if ($conn->query($sql) === TRUE) {
            echo "Nuevo plato insertado exitosamente";
        } else {
            echo "Error al insertar plato: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>