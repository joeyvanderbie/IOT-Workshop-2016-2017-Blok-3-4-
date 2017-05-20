<?php
  require_once('config.php');
  require_once('database.php');
  
  $response = -1;
 if(isset($_GET['t'])) {
    switch($_GET['t']) {
	// create cases for putting stuff in the database or receiving stuff from IT
	// ultimately we want a database with a chipID, with Colors
	// but for now let's add: PUT STUFF IN DB & RECEIVE STUFF FROM DB
	
	case 'ss'://receive stuff
		$stmt = $pdo->prepare("INSERT INTO test_mesage (message) VALUES ('1')");
	   if ($stmt->execute()) {
	    $response = 1;
	   }
	   break;
	case 'rs': // get the suck and delete the cuck
	
	 $stmt = $pdo->prepare("SELECT * FROM test_message");
              $dc = $stmt->fetch();
			  echo $dc;
	$stmt = $pdo->prepare("DELETE FROM test_mesage");
	if ($stmt->execute()) {
		$response = $dc['1'];
		//$response = "yo";
	   }
	   echo $response;
	   break;
	}
 }

?>