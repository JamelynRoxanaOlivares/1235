<?php
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

$id = intval($_GET['id']);
$sql = "SELECT c.numero_catorcena, c.leyenda, c.inicio_catorcena, c.termino_catorcena, 
               t.nombre, t.apellidos, t.numero_trabajador, t.puesto 
        FROM catorcenas c 
        LEFT JOIN trabajadores t ON c.id = t.catorcena_id 
        WHERE c.id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
    <th>No Catorcena</th>
    <th>Denominación</th>
    <th>Periodo</th>
    <th>Nombre</th>
    <th>Apellidos</th>
    <th>Número de Trabajador</th>
    <th>Puesto</th>
    </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["numero_catorcena"] . "</td>";
        echo "<td>" . $row["leyenda"] . "</td>";
        $inicio = date("d F Y", strtotime($row["inicio_catorcena"]));
        $termino = date("d F Y", strtotime($row["termino_catorcena"]));
        echo "<td>" . $inicio . " al " . $termino . "</td>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["apellidos"] . "</td>";
        echo "<td>" . $row["numero_trabajador"] . "</td>";
        echo "<td>" . $row["puesto"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}

$conn->close();
?>
