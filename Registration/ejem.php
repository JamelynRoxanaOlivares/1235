<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y CRUD de Personal</title>
    <link rel="stylesheet" href="/rcourses/css/registration.css">
    <style>
        /* Estilos para el encabezado */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px 20px;
        }

        .logo img {
            height: 40px; /* Ajusta el tamaño según sea necesario */
        }

        .search-bar {
            flex-grow: 1;
            margin: 0 20px;
        }

        .search-bar input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-left: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        /* Estilos para el pie de página */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 300px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #f1f1f1}

        .dropdown:hover .dropdown-content {display: block;}

        .dropdown:hover .dropbtn {background-color: #0056b3;}

        .page-link {
            color: #007bff;
            text-decoration: none;
            padding: 5px;
        }

        .page-link:hover {
            text-decoration: underline;
        }

        .current-page {
            font-weight: bold;
            padding: 5px;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <header>
        <div class="logo">
            <a href="#"><img src="ruta_del_logo.png" alt="Logo"></a>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Buscar...">
            <button type="submit">Buscar</button>
        </div>
      
    </header>
    <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Acerca de</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
    <div class="container">
        <div class="left-column">
            <h2>Registro de Personal</h2>
            <form action="/Registration/registrar_personal.php" method="post">
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" required><br>

                <label for="apellidos">Apellidos:</label><br>
                <input type="text" id="apellidos" name="apellidos" required><br>

                <label for="numero_trabajador">Número de Trabajador:</label><br>
                <input type="number" id="numero_trabajador" name="numero_trabajador" required><br>

                <label for="puesto">Puesto:</label><br>
                <select id="puesto" name="puesto" required>
                    <option value="Supervisor de INgieneria ">Supervisor de Ingeniería Electromecánica</option>
                    <option value="Sin determinar">Sin determinar</option>
                </select><br><br>

                <input type="submit" value="Registrar">
            </form>
        </div>
        <div class="right-column">
            <h2>Lista de Personal</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Número de Trabajador</th>
                    <th>Puesto</th>
                    <th>Opciones</th>
                </tr>
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

                // Paginación
                $limit = 5; // Número de registros por página
                $page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual
                $start = ($page - 1) * $limit; // Registro inicial para la página actual

                // Consulta para obtener los datos de la tabla personal con paginación
                $sql = "SELECT id, nombre, apellidos, numero_trabajador, puesto FROM personal LIMIT $start, $limit";
                $result = $conn->query($sql);

                // Mostrar datos de cada fila en la tabla
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row["id"]."</td>";
                        echo "<td>".$row["nombre"]."</td>";
                        echo "<td>".$row["apellidos"]."</td>";
                        echo "<td>".$row["numero_trabajador"]."</td>";
                        echo "<td>".$row["puesto"]."</td>";
                        // Agregar botón desplegable para editar y eliminar
                        echo "<td>";
                        echo "<div class='dropdown'>";
                        echo "<button class='dropbtn'>Opciones</button>";
                        echo "<div class='dropdown-content'>";
                        echo "<a href='editar_personal.php?id=".$row["id"]."'>Editar</a>";
                        echo "<a href='#' onclick='showConfirmation(".$row["id"].")'>Eliminar</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron resultados</td></tr>";
                }

                // Obtener el número total de registros
                $total_pages_sql = "SELECT COUNT(*) FROM personal";
                $result = $conn->query($total_pages_sql);
                $total_rows = mysqli_fetch_array($result)[0];
                $total_pages = ceil($total_rows / $limit);

                // Mostrar las flechas para navegar entre las páginas
                echo "<tr><td colspan='6' class='pagination'>";
                if ($page > 1) {
                    echo "<a class='page-link' href='?page=".($page - 1)."'>&laquo; Anterior</a> ";
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($page == $i) {
                        echo "<span class='current-page'>".$i."</span> ";
                    } else {
                        echo "<a class='page-link' href='?page=".$i."'>".$i."</a> ";
                    }
                }
                if ($page < $total_pages) {
                    echo "<a class='page-link' href='?page=".($page + 1)."'>Siguiente &raquo;</a>";
                }
                echo "</td></tr>";

                $conn->close();
                ?>
            </table>
        </div>
    </div>
<br><br><br>
    <!-- Pie de página -->
    <footer>
        <p>&copy; 2024 Nombre de la empresa. Todos los derechos reservados.</p>
        <p>Contacto: info@empresa.com</p>
    </footer>

    <!-- Código HTML para el cuadro de confirmación (oculto inicialmente) -->
    <div id="confirmModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p>¿Estás seguro de que deseas eliminar este registro?</p>
        <button onclick="deleteRecord()">Sí</button>
        <button onclick="closeModal()">No</button>
        <input type="hidden" id="recordId">
      </div>
    </div>

    <script>
    // Función para mostrar el cuadro de confirmación
    function showConfirmation(id) {
      // Mostrar el modal
      var modal = document.getElementById("confirmModal");
      modal.style.display = "block";
      
      // Guardar el ID del registro que se va a eliminar en un campo oculto dentro del modal
      document.getElementById("recordId").value = id;
    }

    // Función para cerrar el cuadro de confirmación
    function closeModal() {
      // Ocultar el modal
      var modal = document.getElementById("confirmModal");
      modal.style.display = "none";
    }

    // Función para eliminar el registro
    function deleteRecord() {
      // Obtener el ID del registro a eliminar desde el campo oculto dentro del modal
      var id = document.getElementById("recordId").value;
      
      // Redirigir a la página de eliminar_personal.php con el ID del registro como parámetro
      window.location.href = "eliminar_personal.php?id=" + id;
    }
    </script>
</body>
</html>
