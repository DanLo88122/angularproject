<?php

//insert.php

include('database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$first_name = '';
$last_name = '';

if($form_data->action == 'fetch_single_data')
{
	$query = "SELECT * FROM motivos_es_gt WHERE id='".$form_data->id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output['motivo'] = $row['motivo'];
        $output['des_motivo'] = $row['des_motivo'];
        $output['estado'] = $row['estado'];
		$output['tipo'] = $row['tipo'];
	}
}
elseif($form_data->action == "Delete")
{
	$query = "
	DELETE FROM motivos_es_gt WHERE id='".$form_data->id."'
	";
	$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$output['message'] = 'Datos eliminados';
	}
}
else
{
	if(empty($form_data->motivo))
	{
		$error[] = 'El motivo es requerido';
	}
	else
	{
		$motivo = $form_data->motivo;
	}

	if(empty($form_data->des_motivo))
	{
		$error[] = 'El desmotivo es requerido';
	}
	else
	{
		$desmotivo = $form_data->desmotivo;
    }
    
    

    if(empty($form_data->estado))
	{
		$error[] = 'El estado es requerido';
	}
	else
	{
		$estado = $form_data->estado;
    }
    
    if(empty($form_data->tipo))
	{
		$error[] = 'El tipo es requerido';
	}
	else
	{
		$tipo = $form_data->tipo;
	}





	if(empty($error))
	{
		if($form_data->action == 'Insert')
		{
			$data = array(
				':motivo'		=>	$motivo,
                ':des_motivo'		=>	$des_motivo,
                ':estado'		=>	$estado,
                ':tipo'		=>	$tipo
			);
			$query = "
			INSERT INTO motivos_es_gt 
				(motivo, des_motivo,estado,tipo) VALUES 
				(:motivo, :des_motivo, :estado, :tipo)
			";
			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Datos ingresados exitosamente';
			}
		}
		if($form_data->action == 'Edit')
		{
			$data = array(
				':motivo'		=>	$motivo,
                ':des_motivo'		=>	$des_motivo,
                ':estado'		=>	$estado,
                ':tipo'		=>	$tipo
			);
			$query = "
			UPDATE motivos_es_gt 
			SET motivo = :motivo, des_motivo = :des_motivo, estado = :estado, tipo = :tipo 
			WHERE motivo = :motivo
			";

			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Data Edited';
			}
		}
	}
	else
	{
		$validation_error = implode(", ", $error);
	}

	$output = array(
		'error'		=>	$validation_error,
		'message'	=>	$message
	);

}



echo json_encode($output);

?>