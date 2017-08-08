<?php
    include ('../../conexion.php');
	$salida = "";
	$query= "SELECT orden.responsable,orden.total,estado.descripcion as Estado_orden,estado_pago.descripcion as Estado_pago,orden.fecha_inicio,orden.fecha_entrega FROM orden
		INNER JOIN estado ON estado.id = orden.estado_id
		INNER JOIN estado_pago ON estado_pago.id = orden.estado_pago_id";

	if (isset($_POST['consulta'])) {
		$q=$conn->real_escape_string($_POST['consulta']);
		$query = "SELECT orden.responsable,orden.total,estado.descripcion as Estado_orden,estado_pago.descripcion 	 as Estado_pago,orden.fecha_inicio,orden.fecha_entrega FROM orden
				INNER JOIN estado ON estado.id = orden.estado_id
				INNER JOIN estado_pago ON estado_pago.id = orden.estado_pago_id
				WHERE  UPPER(estado.descripcion) LIKE UPPER('%$q%') OR UPPER(orden.responsable) like UPPER('%$q%') OR  UPPER(orden.fecha_entrega)  like UPPER('%$q%') OR  UPPER(estado_pago.descripcion)  like UPPER('%$q%')";
	}

	
		$resultado = $conn->query($query);
		if ($resultado->num_rows > 0) {
			$salida.="<table class='striped responsive-table centered' border='1'>
		<thead>  
    <tr>
    	
        <th>Responsable</th>
        <th>Estado de orden</th>
        <th>Estado de pago</th>
        <th>Fecha de inicio</th>
        <th>Fecha de entrega</th>
        <th>Total</th>
        <th>Opciones</th>
    </tr>
    </thead><tbody>";

			while($row=$resultado->fetch_assoc()){
		$salida.="
				<tr id='cuerpo'>
					
					<td id='identifica'>".$row['responsable']."</td>
					<td>".$row['Estado_orden']."</td>
					<td>".$row['Estado_pago']."</td>
					<td>".$row['fecha_inicio']."</td>
					<td>".$row['fecha_entrega']."</td>
					<td>".$row['total']."</td>
					<td>
						<a class='btn-floating btn-large waves-effect waves-light blue darken-1 tooltipped' data-position='left' data-delay='50' data-tooltip='Realizar abono'><i class='material-icons'>attach_money</i>
						</a>

						<a class='btn-floating btn-large waves-effect waves-light teal tooltipped' data-position='top' data-delay='50' data-tooltip='Detalle de la orden'><i class='material-icons'>add_to_photos</i></a>

						<a class='btn-floating btn-large waves-effect waves-light grey darken-1 tooltipped' data-position='right' data-delay='50' data-tooltip='Generar PDF'><i class='material-icons'>picture_as_pdf</i></a>	
					</td>
					
				</tr>";
			}
			$salida.="</tbody></table>";
		}else{
			$salida.="<p class='pink-text lighten-5'>No se encontraron datos....</p>";
		}
	echo $salida;
?>
