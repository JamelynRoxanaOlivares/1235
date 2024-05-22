<?php
// Conexión a la base de datos (reemplaza los valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "catorcena";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el parámetro de denominación si existe
$denominacion = isset($_GET['denominacion']) ? $_GET['denominacion'] : '';

// Construir la consulta SQL con o sin el filtro de denominación
$sql = "SELECT numero_catorcena, leyenda, inicio_catorcena, termino_catorcena FROM catorcenas";
if (!empty($denominacion)) {
    $sql .= " WHERE leyenda = '" . $conn->real_escape_string($denominacion) . "'";
}

$result = $conn->query($sql);

// Crear una tabla HTML con los datos obtenidos
if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
    <th>No Catorcena</th>
    <th>Denominación</th>
    <th>Periodo</th>
    </tr>";
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["numero_catorcena"] . "</td>";
        echo "<td>" . $row["leyenda"] . "</td>";
        // Calculando el periodo en el formato deseado
        $inicio = date("d F Y", strtotime($row["inicio_catorcena"]));
        $termino = date("d F Y", strtotime($row["termino_catorcena"]));
        echo "<td>" . $inicio . " al " . $termino . "</td>"; // Mostrando el periodo en la columna correspondiente
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}

$conn->close();
?>
