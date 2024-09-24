<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$codigo = $_POST["codigo"];
$fecha_inicio = $_POST["fecha_inicio"];
$fecha_fin = $_POST["fecha_fin"];
$fecha_expedicion = $_POST["fecha_expedicion"];
$num_personas = $_POST["num_personas"];
$estado_reserva = $_POST["estado_reserva"];
$valor_reserva = $_POST["valor_reserva"];
$generada_por_id = $_POST["generada_por_id"];
$generada_por_tipoid = $_POST["generada_por_tipoid"];
$revisada_por_id = $_POST["revisada_por_id"];
$revisada_por_tipoid = $_POST["revisada_por_tipoid"];

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
if ($generada_por_id == $revisada_por_id && $generada_por_tipoid == $revisada_por_tipoid){
	echo "Error: El recepcionista que genera no puede ser el mismo que revisa.";
} else if ($revisada_por_id == "" && $revisada_por_tipoid == ""){
	$query = "INSERT INTO `reserva`(`codigo`,`fecha_inicio`, `fecha_fin`, `fecha_expedicion`, `num_personas`, `estado_reserva`, `valor_reserva`, `generada_por_id`, `generada_por_tipoid`, `revisada_por_id`, `revisada_por_tipoid`) VALUES ('$codigo', '$fecha_inicio', '$fecha_fin', '$fecha_expedicion', '$num_personas', '$estado_reserva', '$valor_reserva', '$generada_por_id', '$generada_por_tipoid', NULL , NULL)";
}else{
	$query = "INSERT INTO `reserva`(`codigo`,`fecha_inicio`, `fecha_fin`, `fecha_expedicion`, `num_personas`, `estado_reserva`, `valor_reserva`, `generada_por_id`, `generada_por_tipoid`, `revisada_por_id`, `revisada_por_tipoid`) VALUES ('$codigo', '$fecha_inicio', '$fecha_fin', '$fecha_expedicion', '$num_personas', '$estado_reserva', '$valor_reserva', '$generada_por_id', '$generada_por_tipoid', '$revisada_por_id', '$revisada_por_tipoid')";
}
// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: reserva.php");
else:
	echo "Ha ocurrido un error al crear la reserva";
endif;

mysqli_close($conn);