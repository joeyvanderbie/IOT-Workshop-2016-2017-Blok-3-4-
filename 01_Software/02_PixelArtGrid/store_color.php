<?php
	require_once('config.php');
	require_once('database.php');
if (isset($_GET['t']))
{
	switch($_GET['t'])
	{
	
	case 'ins':
	// Use these parameters and the current SERVER timestamp to 
	// store the data in the locations table
	if(isset($_GET['chipid']) && isset($_GET['position']) && isset($_GET['color'])) {
		// Execute the query
		$stmt = $pdo->prepare("SELECT * FROM icu_grid_configuration WHERE position = ?");
		if ($stmt->execute([$_GET["position"]])) {
			if($stmt->rowCount() > 0) {
				$valueColor = "#" . $_GET['color'];
				echo $valueColor;
			  // Determine which fields to update
			  $data = $stmt->fetch();
			  // Update
			  $stmt = $pdo->prepare("UPDATE icu_grid_configuration SET chipid = ?, color = ? WHERE position = ?");
			} 
			if ($stmt->execute([$_GET["chipid"], $valueColor, $_GET["position"]])) {
				echo "done";
			}
			else{
				echo "not done";
			}
		}
		else{
			echo "wrong execute";
		}
	}
	break;
	
	case 'upd':
		if(isset($_GET['position']) && isset($_GET['color'])) 
		{
		$valueColor = "#" . $_GET['color'];
		 $stmt = $pdo->prepare("UPDATE icu_grid_configuration SET color = ? WHERE position = ?");
			} 
			if ($stmt->execute( [$valueColor, $_GET["position"]])) {
				echo "done";
		}
		break;
	
	case 'del':
		if(isset($_GET['position']))
		{
			 $stmt = $pdo->prepare("UPDATE icu_grid_configuration SET chipid = null, color = null, name = null WHERE position = ?");
			if ($stmt->execute([$_GET["position"]])) {
				echo "done";
		}
		}
		break;
	}
}
?>