<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar la CP de la entidad
$idEliminar = $_POST["idEliminar"];
$tipoIdEliminar = $_POST["tipoIdEliminar"];

// Query SQL a la BD
$query = "DELETE FROM empleado WHERE id = '$idEliminar' AND tipo_id = '$tipoIdEliminar'";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

if($result): 
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
    header ("Location: empleado.php");
else:
    echo "Ha ocurrido un error al eliminar este registro";
endif;
 
mysqli_close($conn);