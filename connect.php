<?php
require 'vendor/autoload.php';
require 'libs/NotORM.php';

// database config
// server database

$server ='localhost';
//database name
$db_name='db_asdos';
// database user
$db_user='root';
//database password
$db_pass='root';

$pdo = new PDO("mysql:host=$server;dbname=$db_name",$db_user, $db_pass);
$db=new NotORM($pdo);
 ?>
