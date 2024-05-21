<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y CRUD de Personal</title>
    <link rel="stylesheet" href="/rcourses/css/prenom.css">
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
        <div class="left-column">
            <?php include 'registration_form.php'; ?>
        </div>
        <div class="right-column">
            <h2>Buscar y Editar Personal</h2>
            <form id="modeForm">
                <label for="mode">Modo de cuatrimestre:</label><br>
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
    </script>
</body>
</html>
