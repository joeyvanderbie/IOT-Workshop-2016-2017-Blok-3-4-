<?php
$servername = 'oege.ie.hva.nl';
$username = 'marcelp001';
$password = 'eLc+nO/OAx$8ng';
$db = 'zmarcelp001';
$dsn = "mysql:host={$servername};dbname={$db}";


try {
 $pdo = new PDO($dsn , $username, $password);
} catch(PDOException $e) {
  die($e->getMessage());
}
return $pdo;
?>