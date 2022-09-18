<?php
require_once realpath(__DIR__ . '/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
    
$HOST = $_ENV['HOST'];
$dbname = $_ENV['DBname'];
$image_base_url = "http://localhost/PHPCrud/images/";

$pdo = null;
try{
    $pdo = new PDO("mysql:host=$HOST;dbname=$dbname",$_ENV['DBusername'],$_ENV['DBpassword']);

}catch(PDOException $err){
    echo $err;
}

return $pdo;