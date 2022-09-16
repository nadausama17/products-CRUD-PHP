<?php
    require_once realpath(__DIR__ . '/vendor/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'] ?? null;

        if(!$id){
            header('Location: index.php');
        }

        $HOST = $_ENV['HOST'];
        $dbname = $_ENV['DBname'];
        $pdo = null;
        try{
            $pdo = new PDO("mysql:host=$HOST;dbname=$dbname",$_ENV['DBusername'],$_ENV['DBpassword']);
        }catch(PDOException $err){
            echo $err;
        }

        $statement = $pdo->prepare('select * from products where id= :id');
        $statement-> bindValue(':id',$id);
        $statement -> execute();
        $product = $statement ->fetch(PDO::FETCH_ASSOC);
        unlink('images/'.$product['image']);
        rmdir('images/'.dirname($product['image']));
    
        $statement = $pdo ->prepare('delete from products where id= :id');
        $statement-> bindValue(':id',$id);
        $statement -> execute();

        header('Location: index.php');
    }else{
        header('Location: index.php');
    }
?>