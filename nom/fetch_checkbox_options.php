<?php
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

// Consulta para obtener los nombres únicos
$sql = "SELECT DISTINCT nombre, apellidos, numero_trabajador, puesto FROM personal";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<input type='checkbox' name='selectedNames[]' value='".$row["nombre"].",".$row["apellidos"].",".$row["numero_trabajador"].",".$row["puesto"]."'>".$row["nombre"]." ".$row["apellidos"]."<br>";
    }
}

$conn->close();
?>
