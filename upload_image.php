<?php
try{
    $image_path = get_random_directory().'/'.$image['name'];
    $statement ->bindValue(':image',$image_path);
    $statement ->execute();

    mkdir(dirname('images/'.$image_path));
    move_uploaded_file($image['tmp_name'],'images/'.$image_path);
}catch(PDOException $e){
    echo $e;
    exit;
}