<?php
// Verificamos si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["day"])) {
    // Procesamos la fecha seleccionada
    $selected_date = $_POST["day"];
    $date = new DateTime($selected_date);
    $start_date = $date->format('Y-m-01'); // Primer día del mes seleccionado
    $end_date = $date->format('Y-m-t'); // Último día del mes seleccionado

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
    for ($i = 1; $i <= 12; $i++) {
        // Calculamos las fechas de inicio y término de la catorcena
        $inicio_catorcena = date('Y-m-d', strtotime($start_date . " + " . ($i - 1) * 14 . " days"));
        $termino_catorcena = date('Y-m-d', strtotime($start_date . " + " . ($i * 14 - 1) . " days"));
        $leyenda = "Catorcena " . $i . " de " . date('F', strtotime($inicio_catorcena));

        // Preparamos la consulta SQL
        $sql = "INSERT INTO catorcenas (numero_catorcena, leyenda, inicio_catorcena, termino_catorcena) 
                VALUES ($i, '$leyenda', '$inicio_catorcena', '$termino_catorcena')";

        // Ejecutamos la consulta
        if ($conn->query($sql) !== TRUE) {
            echo "Error al insertar los datos: " . $conn->error;
        }
    }

    // Cerramos la conexión
    $conn->close();
}
?>
