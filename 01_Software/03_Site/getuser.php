<?php
 require_once('config.php');
 require_once('database.php');
 
 
 $stmt = $pdo->prepare("SELECT * FROM icu_grid_configuration ORDER BY position ASC");
 $json_array = array();
 if ($stmt->execute()) {
	 
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$json_array[] = $result;
	}
		echo json_encode($json_array);
			}else {
				echo 'error';
			}
?>				