<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Catorcenas</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
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
        form {
            margin: 20px auto;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
            padding: 10px;
            width: 200px;
            margin-bottom: 20px;
        }
        button {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .table-container {
            margin-bottom: 100px; /* Space between the table and the footer */
        }
        footer {
            background-color: #1e90ff;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px; 
        }
    </style>
</head>
<body>
    <header>
        <img src="https://via.placeholder.com/60" alt="Logo" onclick="window.location.href='https://www.example.com';">
        <h1>Generador de Catorcenas</h1>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Opciones</a>
                    <ul>
                        <li><a href="#">Opción 1</a></li>
                        <li><a href="#">Opción 2</a></li>
                        <li><a href="#">Opción 3</a></li>
                    </ul>
                </li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <form id="dateForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="day">Selecciona la fecha de inicio de la primera catorcena del año:</label>
        <input type="text" id="datepicker" name="day">
        <button type="submit" name="generate">Generar Tabla</button>
        <button type="submit" name="delete">Eliminar Registros</button>
    </form>

    <div class="table-container">
    <?php
    // Datos de conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "catorcena";

    // Creamos la conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificamos la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Si se ha hecho clic en el botón "Eliminar Registros"
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
        $sql = "DELETE FROM catorcenas";
        if ($conn->query($sql) === TRUE) {
            echo "Todos los registros han sido eliminados.";
        } else {
            echo "Error al eliminar los registros: " . $conn->error;
        }
    }

    // Si se ha hecho clic en el botón "Generar Tabla"
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["day"]) && isset($_POST["generate"])) {
        // Procesamos la fecha seleccionada
        $selected_date = $_POST["day"];

        // Eliminamos las catorcenas existentes
        $conn->query("DELETE FROM catorcenas");

        // Insertamos los datos de las catorcenas en la base de datos
        $numero_catorcena = 0; // Inicializamos el contador global
        $mes_actual = date('n', strtotime($selected_date));
        $anio_actual = date('Y', strtotime($selected_date));
        $i = 1; // Inicializamos el contador de catorcenas
        $contador_mensual = 1; // Inicializamos el contador mensual

        while (true) {
            // Calculamos las fechas de inicio y término de la catorcena
            $inicio_catorcena = date('Y-m-d', strtotime($selected_date . " + " . ($i - 1) * 14 . " days"));
            $termino_catorcena = date('Y-m-d', strtotime($inicio_catorcena . " + 13 days"));

            // Si la catorcena pertenece al año siguiente, salimos del bucle
            if (date('Y', strtotime($inicio_catorcena)) > $anio_actual) {
                break;
            }

            // Incrementamos el contador global
            $numero_catorcena++;

            // Construimos la leyenda
            $mes_inicio = date('n', strtotime($inicio_catorcena));
            if ($mes_inicio != $mes_actual) {
                $mes_actual = $mes_inicio;
                $contador_mensual = 1; // Reiniciamos el contador mensual al cambiar de mes
            }
            $leyenda = "Catorcena " . $contador_mensual . " de " . date('F', strtotime($inicio_catorcena));

            // Preparamos la consulta SQL para insertar los datos
            $sql = "INSERT INTO catorcenas (numero_catorcena, leyenda, inicio_catorcena, termino_catorcena) 
                    VALUES (?, ?, ?, ?)";

            // Creamos una sentencia preparada
            $stmt = $conn->prepare($sql);

            // Ligamos los parámetros con los valores
            $stmt->bind_param("isss", $numero_catorcena, $leyenda, $inicio_catorcena, $termino_catorcena);

            // Ejecutamos la consulta
            if ($stmt->execute() !== TRUE) {
                echo "Error al insertar los datos: " . $conn->error;
            }

            // Cerramos la sentencia preparada
            $stmt->close();

            // Incrementamos el contador de catorcenas y el contador mensual
            $i++;
            $contador_mensual++;
        }
    }

    // Obtenemos las catorcenas de la base de datos
    $sql = "SELECT numero_catorcena, leyenda, inicio_catorcena, termino_catorcena FROM catorcenas";
    $result = $conn->query($sql);

    // Mostramos la tabla de catorcenas
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Número de Catorcena</th><th>Leyenda</th><th>Inicio de Catorcena</th><th>Término de Catorcena</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["numero_catorcena"]. "</td><td>" . $row["leyenda"]. "</td><td>" . $row["inicio_catorcena"]. "</td><td>" . $row["termino_catorcena"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 resultados";
    }

    // Cerramos la conexión
    $conn->close();
    ?>
    </div>

    <footer>
        <p>&copy; 2024 Generador de Catorcenas. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
    } );
    </script>
</body>
</html>
