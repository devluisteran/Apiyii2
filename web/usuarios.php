<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Lista de Usuarios</h4>
        </div>
        <div class="card-body">
            <table id="tablaUsuarios" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>                                  
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    console.log("Documento listo, cargando usuarios...");
    
    // Verificar la URL de la API
    const apiUrl = "index.php?r=api/user/index";
    console.log("Llamando a:", apiUrl);


 
fetch("index.php?r=api/user/index")
.then(response => {
    if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
    }
    return response.json(); // directamente el JSON (array)
})
.then(usuarios => {
    console.log("Usuarios recibidos:", usuarios);


     if (usuarios.data.length === 0) {
    $('#tablaUsuarios tbody').html('<tr><td colspan="4" class="text-center">No hay usuarios con email .biz</td></tr>');
    // No inicializar DataTable o destruirla si ya existe
    if ($.fn.DataTable.isDataTable('#tablaUsuarios')) {
        $('#tablaUsuarios').DataTable().destroy();
    }
    return;
   }
    // Verificar que sea un array
    if (!Array.isArray(usuarios.data)) {
        throw new Error("La respuesta no es un array válido");
    }

    // Destruir DataTable si ya existe
    if ($.fn.DataTable.isDataTable('#tablaUsuarios')) {
        $('#tablaUsuarios').DataTable().destroy();
    }

     // Leer query string
const urlParams = new URLSearchParams(window.location.search);
const sortParam = urlParams.get('sort'); // "asc" o "desc"

// Definir orden inicial: por nombre (columna índice 1) ascendente o descendente
let order = [];
if (sortParam === 'asc') {
    order = [[1, 'asc']];  // Columna 1 = Nombre
} else if (sortParam === 'desc') {
    order = [[1, 'desc']];
} else {
    order = [[0, 'desc']]; // Por defecto ordenar por ID descendente (como antes)
}     


    // Inicializar DataTable con los datos
    $('#tablaUsuarios').DataTable({
        data: usuarios.data,
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'username' }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        pageLength: 10,
        responsive: true,
        order:order
    });
})
.catch(error => {
    console.error("Error completo:", error);
   // alert("Error al cargar usuarios: " + error.message);
    
    // Mostrar mensaje en la tabla
    $('#tablaUsuarios tbody').html(`
        <tr>
            <td colspan="4" class="text-center text-danger">
                Error al cargar los datos.
            </td>
        </tr>
    `);
});
     


 
});
</script>

</body>                                     
</html>
