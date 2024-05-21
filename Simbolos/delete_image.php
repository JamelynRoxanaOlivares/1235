<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "catorcena";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Primero, obtener la ruta de la imagen para poder eliminar el archivo
    $sql = "SELECT image_path FROM images WHERE id = $id";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        $filepath = $row['image_path'];
        if (file_exists($filepath)) {
            unlink($filepath);  // Elimina el archivo de imagen
        }
    }

    // Ahora eliminar la entrada de la base de datos
    $sql = "DELETE FROM images WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Imagen eliminada correctamente";
    } else {
        echo "Error al eliminar imagen: " . $conn->error;
    }
}

$conn->close();
?>
