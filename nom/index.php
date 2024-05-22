<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y CRUD de Personal</title>
    <link rel="stylesheet" href="/rcourses/css/prenom.css">
    <style>
        /* Estilos personalizados */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f7fb; /* Azul claro */
        }

        .header {
            background-color: #1565c0; /* Azul oscuro */
            color: #fff;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            height: 40px;
        }

        .header-title h1 {
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Cambiado a flex-start para alinear la parte izquierda arriba */
            margin-top: 50px;
        }

        .column {
            width: 48%;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-bottom: 20px; /* Espaciado adicional entre columnas */
        }

        .footer {
            background-color: #1565c0; /* Azul oscuro */
            color: #fff;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        h2 {
            color: #1565c0; /* Azul oscuro */
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        th {
            background-color: #1565c0; /* Azul oscuro */
            color: white;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Gris claro */
        }

        tr:hover {
            background-color: #e0f7fa; /* Azul claro al pasar el ratón */
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="/path/to/your/logo.png" alt="Logo">
        <div class="header-title">
            <h1>Registro y CRUD de Personal</h1>
        </div>
        <div class="header-menu">
            <select id="menu">
                <option value="">Menú</option>
                <option value="home">Inicio</option>
                <option value="about">Acerca de</option>
                <option value="contact">Contacto</option>
            </select>
        </div>
    </div>
    
    <div class="container">
        <div class="column">
            <h2>Tabla de Catorcenas</h2>
            <!-- Select de denominación -->
            <label for="denominacionSelect">Denominación:</label>
            <select id="denominacionSelect" onchange="fetchFilteredCatorcenas()">
                <option value="">Todas</option>
            </select>
            <!-- Select de turno -->
            <label for="turnoSelect">Turno:</label>
            <select id="turnoSelect" onchange="fetchFilteredCatorcenas()">
                <option value="diurno">Diurno</option>
                <option value="nocturno">Nocturno</option>
            </select>
            <div id="catorcenasTable">
                <?php include('fetch_catorcenas.php'); ?>
            </div>
        </div>
        <div class="column">
            <h2>Buscar y Editar Personal</h2>
            <form id="modeForm">
                <label for="mode">Modo de cuatrimestre:</label>
                <select id="mode" name="mode" onchange="updateForm()">
                    <option value="">Seleccione un modo</option>
                    <option value="individual">Individual</option>
                    <option value="seleccionados">Seleccionados</option>
                    <option value="todos">Todos</option>
                </select>
            </form>
            <div id="formContainer"></div>
        </div>
    </div>

    <div class="footer">
        &copy; 2024 Registro y CRUD de Personal. Todos los derechos reservados.
    </div>

    <script>
        // Cargar las denominaciones cuando se carga la página
        window.addEventListener('DOMContentLoaded', function () {
            fetch('fetch_denominaciones.php')
                .then(response => response.json())
                .then(data => {
                    var denominacionSelect = document.getElementById('denominacionSelect');
                    data.forEach(denominacion => {
                        var option = document.createElement('option');
                        option.value = denominacion;
                        option.text = denominacion;
                        denominacionSelect.add(option);
                    });
                })
                .catch(error => console.error('Error al obtener las denominaciones:', error));

            fetch('fetch_catorcenas.php')
                .then(response => response.text())
                .then(data => document.getElementById('catorcenasTable').innerHTML = data);
        });

        function updateForm() {
            var mode = document.getElementById("mode").value;
            var formContainer = document.getElementById("formContainer");

            if (mode === "individual") {
                fetch('select_form.php')
                    .then(response => response.text())
                    .then(data => formContainer.innerHTML = data);
            } else if (mode === "seleccionados") {
                fetch('select_form_checklist.php')
                    .then(response => response.text())
                    .then(data => formContainer.innerHTML = data);
            } else if (mode === "todos") {
                fetch('select_form_all.php')
                    .then(response => response.text())
                    .then(data => formContainer.innerHTML = data);
            } else {
                formContainer.innerHTML = '';
            }
        }

        function fetchDetails(value) {
            var splitValue = value.split(",");
            document.getElementById("nombre").value = splitValue[0];
            document.getElementById("apellidos").value = splitValue[1];
            document.getElementById("numero_trabajador").value = splitValue[2];
            document.getElementById("puesto").value = splitValue[3];
        }

        // Función para filtrar catorcenas por denominación y turno
        function fetchFilteredCatorcenas() {
            var denominacion = document.getElementById('denominacionSelect').value;
            var turno = document.getElementById('turnoSelect').value;
            var url = 'fetch_catorcenas.php';
            var params = [];

            if (denominacion) {
                params.push('denominacion=' + encodeURIComponent(denominacion));
            }
            if (turno) {
                params.push('turno=' + encodeURIComponent(turno));
            }

            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            fetch(url)
                .then(response => response.text())
                .then(data => document.getElementById('catorcenasTable').innerHTML = data)
                .catch(error => console.error('Error al obtener las catorcenas:', error));
        }

        // Función para obtener y mostrar detalles de la catorcena seleccionada
        function fetchCatorcenaDetails() {
            var catorcenaId = document.getElementById('catorcenaSelect').value;
            if (catorcenaId) {
                fetch('fetch_catorcena_worker_details.php?id=' + catorcenaId)
                    .then(response => response.text())
                    .then(data => {
                        // Llena el contenedor con los detalles de la catorcena
                        document.getElementById('catorcenaDetails').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error al obtener detalles de la catorcena:', error);
                    });
            }
        }

        // Carga inicial de los detalles de la primera catorcena (puedes eliminar esto si no es necesario)
        fetchCatorcenaDetails();
    </script>
</body>
</html>
