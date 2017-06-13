<?php
	require_once('config.php');
	require_once('database.php');

	// Si tout va bien, on peut continuer
	
	$epochtime = time() + 10;
	
	if(isset($_GET['t'])){
    switch($_GET['t']) {
      case 'del': // getColor
        $stmt = $pdo->prepare("DELETE FROM icu_grid_queue");
		$stmt->execute();
      break;
      case 'ins': //getready
	$stmt = $pdo->prepare("DELETE FROM icu_grid_queue");
	$stmt->execute();
	$stmt = $pdo->prepare("INSERT INTO icu_grid_queue set ready = 1, epochtime = $epochtime");
	$stmt->execute();
	break;
	}
	}

?>