<?php
$this->title = 'Usuarios';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<div class="container mt-5">
    <h2 class="mb-4">Usuarios</h2>

    <div id="alerta"></div>

    <table id="tablaUsuarios" class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Ciudad</th>
                <th>Empresa</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {

    const tabla = $('#tablaUsuarios').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });

    $.ajax({
        url: "index.php?r=api/user",
        method: "GET",
        success: function(data) {

            tabla.clear();

            data.forEach(user => {
                tabla.row.add([
                    user.id,
                    user.name,
                    user.email,
                    user.address.city,
                    user.company.name
                ]);
            });

            tabla.draw();
        },
        error: function() {
            $('#alerta').html(`
                <div class="alert alert-danger">
                    Error al cargar los usuarios.
                </div>
            `);
        }
    });

});
</script>
