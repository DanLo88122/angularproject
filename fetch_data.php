<?php

//fetch_data.php

include('database_connection.php');

$query = "SELECT * FROM motivo_es_gt";
$statement = $connect->prepare($query);
if($statement->execute())
{
	while($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		$data[] = $row;
	}

	echo json_encode($data);
}

//fetch_data.php

// include('database_connection.php');

// $query = "SELECT  * FROM motivos_es_gt limit 2 ";
// $statement = $connect->prepare($query);

// try{
// 	$result = $statement->execute();
//     echo 'fff'.$result;
// if($result == 1)
// {
// 	while($row = $statement->fetch(PDO::FETCH_ASSOC))
// 	{
// 		$data[] = $row;
// 	}

// 	echo json_encode($data);
// }
// }catch(Exception $e){
// 	echo 'Caught exception: ',  $e->getMessage(), "\n";
// }


?>






