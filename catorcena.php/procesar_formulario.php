<?php
// Verificamos si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["day"])) {
    // Procesamos la fecha seleccionada
    $selected_date = $_POST["day"];

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

    // Insertamos los datos de las catorcenas en la base de datos
    $numero_catorcena = 0; // Inicializamos el contador global
    $mes_actual = date('n', strtotime($selected_date));
    $anio_actual = date('Y', strtotime($selected_date));
    $i = 1; // Inicializamos el contador de catorcenas
    while (true) {
        // Calculamos las fechas de inicio y término de la catorcena
        $inicio_catorcena = date('Y-m-d', strtotime($selected_date . " + " . ($i - 1) * 14 . " days"));
        $termino_catorcena = date('Y-m-d', strtotime($inicio_catorcena . " + 13 days"));

        // Incrementamos el contador global
        $numero_catorcena++;

        // Construimos la leyenda
        $leyenda = "Catorcena " . $numero_catorcena . " de " . date('F', strtotime($inicio_catorcena));

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

        // Si la catorcena pertenece al año siguiente, salimos del bucle
        if (date('Y', strtotime($inicio_catorcena)) > $anio_actual) {
            break;
        }

        // Incrementamos el contador de catorcenas
        $i++;
    }

    // Cerramos la conexión
    $conn->close();
}
?>
