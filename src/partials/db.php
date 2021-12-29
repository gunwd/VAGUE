<?php
// DB Config
$host = 'localhost';
$user = 'root';
$password = '441632';
$dbname = 'projet';

// DSN
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;


try {
  // PDO
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

session_start();

?>