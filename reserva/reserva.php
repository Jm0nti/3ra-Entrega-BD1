<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Entidad RESERVA (ANÁLOGA A REVISIÓN)</h1>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="reserva_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="number" class="form-control" id="codigo" name="codigo" required>
        </div>

        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
        </div>

        <div class="mb-3">
            <label for="fecha_fin" class="form-label">Fecha Fin</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
        </div>

        <div class="mb-3">
            <label for="fecha_expedicion" class="form-label">Fecha de Expedición</label>
            <input type="date" class="form-control" id="fecha_expedicion" name="fecha_expedicion" required>
        </div>

        <div class="mb-3">
            <label for="num_personas" class="form-label">Número de Personas</label>
            <input type="number" class="form-control" id="num_personas" name="num_personas" required>
        </div>

        <div class="mb-3">
    <label for="estado_reserva" class="form-label">Estado Reserva</label>
    <select name="estado_reserva" id="estado_reserva" class="form-select" required>
        <option value="" selected disabled hidden></option>
        <option value="finalizada">Finalizada</option>
        <option value="cancelada">Cancelada</option>
        <option value="en curso">En curso</option>
    </select>
</div>


        <div class="mb-3">
            <label for="valor_reserva" class="form-label">Valor Reserva</label>
            <input type="number" class="form-control" id="valor_reserva" name="valor_reserva" required>
        </div>
  
        <div class="mb-3">
            <label for="recepcionista_genera" class="form-label">Recepcionista (Generada por)</label>
            <select name="recepcionista_genera" id="recepcionista_genera" class="form-select" onchange="updateGeneradaPor()" required>
                <option value="" selected disabled hidden></option>
                <?php
                require("../empleado/empleado_select.php");
                if($resultadoEmpleado):
                    foreach ($resultadoEmpleado as $fila):                        
                ?>
                
                <option value="<?= $fila["id"]; ?>-<?= $fila["tipo_id"]; ?>">
                    <?= $fila["nombre"]; ?> - ID: <?= $fila["id"]; ?>, Tipo ID: <?= $fila["tipo_id"]; ?>
                </option> 
                <?php

                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="generada_por_id" class="form-label">Generada por ID</label>
            <input type="number" class="form-control" id="generada_por_id" name="generada_por_id" readonly>
        </div> 

        <div class="mb-3">
            <label for="generada_por_tipoid" class="form-label">Generada por Tipo ID</label>
            <input type="text" class="form-control" id="generada_por_tipoid" name="generada_por_tipoid" readonly>
        </div>

        <div class="mb-3">
            <label for="recepcionista_revisa" class="form-label">Recepcionista (Revisada por)</label>
            <select name="recepcionista_revisa" id="recepcionista_revisa" class="form-select" onchange="updateRevisadaPor()">
                <option value="" selected disabled hidden></option>
                <?php
                require("../empleado/empleado_select.php");
                if($resultadoEmpleado):
                    foreach ($resultadoEmpleado as $fila):                        
                ?>
                <option value="<?= $fila["id"]; ?>-<?= $fila["tipo_id"]; ?>">
                    <?= $fila["nombre"]; ?> - ID: <?= $fila["id"]; ?>, Tipo ID: <?= $fila["tipo_id"]; ?>
                </option> 
                <?php
                        
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="revisada_por_id" class="form-label">Revisada por ID</label>
            <input type="number" class="form-control" id="revisada_por_id" name="revisada_por_id" readonly>
        </div> 

        <div class="mb-3">
            <label for="revisada_por_tipoid" class="form-label">Revisada por Tipo ID</label>
            <input type="text" class="form-control" id="revisada_por_tipoid" name="revisada_por_tipoid" readonly>
        </div>        

        <button type="submit" class="btn btn-primary">Agregar</button>

    </form>
    
</div>

<script>
function updateGeneradaPor() {
    var selectElement = document.getElementById('recepcionista_genera');
    var selectedValue = selectElement.value;
    var [id, tipoId] = selectedValue.split('-');
    
    document.getElementById('generada_por_id').value = id;
    document.getElementById('generada_por_tipoid').value = tipoId;
}

function updateRevisadaPor() {
    var selectElement = document.getElementById('recepcionista_revisa');
    var selectedValue = selectElement.value;
    var [id, tipoId] = selectedValue.split('-');
    
    document.getElementById('revisada_por_id').value = id;
    document.getElementById('revisada_por_tipoid').value = tipoId;
}
</script>

<?php
// Importar el código del otro archivo
require("reserva_select.php");
            
// Verificar si llegan datos
if($resultadoReserva and $resultadoReserva->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Código</th>
                <th scope="col" class="text-center">Fecha Inicio</th>
                <th scope="col" class="text-center">Fecha Fin</th>
                <th scope="col" class="text-center">Fecha de Expedición</th>
                <th scope="col" class="text-center">Número de Personas</th>
                <th scope="col" class="text-center">Estado Reserva</th>
                <th scope="col" class="text-center">Valor Reserva</th>
                <th scope="col" class="text-center">Generada por ID</th>
                <th scope="col" class="text-center">Generada por Tipo ID</th>
                <th scope="col" class="text-center">Revisada por ID</th>
                <th scope="col" class="text-center">Revisada por Tipo ID</th>                
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoReserva as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["fecha_inicio"]; ?></td>
                <td class="text-center"><?= $fila["fecha_fin"]; ?></td>
                <td class="text-center"><?= $fila["fecha_expedicion"]; ?></td>
                <td class="text-center"><?= $fila["num_personas"]; ?></td>
                <td class="text-center"><?= $fila["estado_reserva"]; ?></td>
                <td class="text-center">$<?= $fila["valor_reserva"]; ?></td>
                <td class="text-center"><?= $fila["generada_por_id"]; ?></td>
                <td class="text-center"><?= $fila["generada_por_tipoid"]; ?></td>
                <td class="text-center"><?= $fila["revisada_por_id"]; ?></td>
                <td class="text-center"><?= $fila["revisada_por_tipoid"]; ?></td>
                
                <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                <td class="text-center">
                    <form action="reserva_delete.php" method="post">
                        <input hidden type="text" name="codigoEliminar" value="<?= $fila["codigo"]; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>

            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<?php
endif;

include "../includes/footer.php";
?>