<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "catorcena";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para obtener los datos del registro
    $sql = "SELECT * FROM personal WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No se encontraron datos.";
        exit();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Personal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px 0;
            text-align: center;
            position: relative;
        }
        header img {
            position: absolute;
            left: 20px;
            top: 10px;
            height: 60px;
            cursor: pointer;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        nav {
            margin-top: 10px;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 15px;
            position: relative;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            transition: background-color 0.3s;
        }
        nav ul li a:hover {
            background-color: #0056b3;
        }
        nav ul li ul {
            display: none;
            position: absolute;
            top: 40px;
            left: 0;
            background-color: #007BFF;
            padding: 0;
            list-style-type: none;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
        }
        nav ul li:hover ul {
            display: block;
        }
        nav ul li ul li {
            width: 150px;
        }
        .container {
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .container h2 {
            color: #1e90ff;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #333;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #1e90ff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #1c86ee;
        }
        .footer {
            background-color: #1e90ff;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px; /* Espacio entre la tabla y el pie de página */
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <img src="ruta/a/tu/imagen.png" alt="Logo">
            <div class="header-title">
                <h1>Editar Personal</h1>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Servicios</a>
                    <ul>
                        <li><a href="#">Servicio 1</a></li>
                        <li><a href="#">Servicio 2</a></li>
                        <li><a href="#">Servicio 3</a></li>
                    </ul>
                </li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Editar Personal</h2>
        <form action="actualizar_personal.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo $row['apellidos']; ?>" required>

            <label for="numero_trabajador">Número de Trabajador:</label>
            <input type="number" id="numero_trabajador" name="numero_trabajador" value="<?php echo $row['numero_trabajador']; ?>" required>

            <label for="puesto">Puesto:</label>
            <select id="puesto" name="puesto" required>
                <option value="Supervisor de Ingeniería" <?php if ($row['puesto'] == 'Supervisor de Ingeniería') echo 'selected'; ?>>Supervisor de Ingeniería Electromecánica</option>
                <option value="Sin determinar" <?php if ($row['puesto'] == 'Sin determinar') echo 'selected'; ?>>Sin determinar</option>
            </select>
            <input type="submit" value="Actualizar">
        </form>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Empresa XYZ. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
