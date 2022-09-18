<?php
    $pdo = require_once './database.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'] ?? null;

        if(!$id){
            header('Location: index.php');
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