<?php
  require_once('config.php');
  require_once('util.php');
  require_once('database.php');
  
  //https://oege.ie.hva.nl/~palr001/icu/api5.php?c=fde9&o=grdy
  // the nodemcu's will receive [color  ,  readyState  ,  epochtime]
  
  $response = -1;
if (isset($_GET['t']))
{
	switch($_GET['t'])
	{
		case 'cnfg': // get's you the following: [color  ,  readyState  ,  epochtime+10]
		if(isset($_GET['c'])) 
		{
			$id = $_GET['c'];
			$stmt = $pdo->prepare("SELECT color FROM icu_grid_configuration WHERE chipid = ?");
			if ($stmt->execute([$_GET['c']]))
			{
				if($stmt->rowCount() > 0) 
				{
				  $data = $stmt->fetch();
				  $color = isset($color) ? $color : $data['color'];
				   echo $response = $color;
				}
			}
		}
		if (isset($_GET['o']) == 'grdy')
		{
		  $sql = "SELECT * FROM icu_grid_queue";
		  $stmt = $pdo->prepare($sql);

			if($stmt->execute())
			{
			$data = $stmt->fetch();
			$ready = $data['ready'];
			$epochtime = $data['epochtime'];
			$response = ",$ready,$epochtime";
			echo $response;
			}
			else
			{
			  $response = 0;
			}  
		}
		break;
		
		case 'data'; // retrieves all data from the icu_grid_configuration
		$stmt = $pdo->prepare("SELECT * FROM icu_grid_configuration ORDER BY position ASC");
		$json_array = array();
		if ($stmt->execute())
		{
			while ($result = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$json_array[] = $result;
			}
			echo json_encode($json_array);
		}else 
		{
			echo 'error';
		}
		break;
	}
}
?>