<?php
include "../includes/header.php";
?>

<h1 class="mt-3">Consulta 1</h1>

<p class="mt-3">
    El primer botón debe mostrar la cédula (tipo de identificación e ID) y el nombre de los tres recepcionistas que más reservas han generado.
</p>

<?php
// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL adaptada a la nueva estructura de recepcionistas
$query = "
    SELECT e.tipo_id, e.id, e.nombre, COUNT(r.codigo) as total_reservas
    FROM empleado e
    JOIN reserva r ON e.id = r.generada_por_id AND e.tipo_id = r.generada_por_tipoid
    WHERE e.entrada IS NOT NULL -- Solo recepcionistas (entrada debe ser 'Principal' o 'Secundaria')
    GROUP BY e.id, e.tipo_id, e.nombre
    ORDER BY total_reservas DESC, e.nombre ASC
    LIMIT 3
";



// Ejecutar la consulta
$resultadoC1 = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<?php
// Verificar si llegan datos
if($resultadoC1 and $resultadoC1->num_rows > 0):
?>

<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Tipo de ID</th>
                <th scope="col" class="text-center">ID</th>
                <th scope="col" class="text-center">Nombre</th>
                <th scope="col" class="text-center">Total de Reservas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultadoC1 as $fila): ?>
            <tr>
                <td class="text-center"><?= $fila["tipo_id"]; ?></td>
                <td class="text-center"><?= $fila["id"]; ?></td>
                <td class="text-center"><?= $fila["nombre"]; ?></td>
                <td class="text-center"><?= $fila["total_reservas"]; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php else: ?>
<div class="alert alert-danger text-center mt-5">
    No se encontraron resultados para esta consulta
</div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>
