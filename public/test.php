<?php
$server = '13.59.221.246';
$port = '3306';
$user = 'postgre';
$pass = 'E10cFq@874E';
$db = 'db_lotus';
// $conn = mysqli_connect($server, $user, $pass, $db, $port);

try
{
  $conn = new PDO("mysql:host=$server;port=$port;dbname=$db", $user, $pass);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$q = $conn->prepare("SELECT * FROM tb_game_details WHERE game_number = 174 ");
$q->execute();
$q = $q->fetch(PDO::FETCH_ASSOC);
// $q = $q->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($q);
