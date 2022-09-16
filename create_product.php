<?php
    require_once realpath(__DIR__ . '/vendor/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $HOST = $_ENV['HOST'];
    $dbname = $_ENV['DBname'];
    $pdo = null;
    try{
        $pdo = new PDO("mysql:host=$HOST;dbname=$dbname",$_ENV['DBusername'],$_ENV['DBpassword']);

    }catch(PDOException $err){
        echo $err;
    }

    $title = '';
    $image = '';
    $price = '';
    $description = '';
    $errors = [];

    function get_random_directory(){
        $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $dirname = "";
        for($i=0; $i<8; $i++){
            $dirname .= $str[rand(0,strlen($str)-1)];
        }
        return $dirname;
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $title = $_POST['title'];
        $image = $_FILES['image'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        if(!$title) $errors['title'] = 'Title is Required';
        if(!$price) $errors['price'] = 'Price is Required';

        if(!is_dir('images')){
            mkdir('images');
        }

        if(empty($errors)){
            $statement = $pdo -> prepare('insert into products (title, image, price, description)
            values (:title, :image, :price, :description)');
            $statement ->bindValue(':title',$title);
            $statement ->bindValue(':price',$price);
            if($description) $statement ->bindValue(':description',$description || null);
            else $statement ->bindValue(':description',null);

            if($image['name']){
                try{
                    $image_path = get_random_directory().'/'.$image['name'];
                    $statement ->bindValue(':image',$image_path);
                    $statement ->execute();

                    mkdir(dirname('images/'.$image_path));
                    move_uploaded_file($image['tmp_name'],'images/'.$image_path);
                    header('Location: index.php');
                }catch(PDOException $e){
                    echo $e;
                }
            }else{
                $statement ->bindValue(':image',null);
                $statement ->execute();
                header('Location: index.php');
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">All Products</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="create_product.php">Create Product</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h2 class="my-5 text-center">Add Product</h2>
    <form class="form w-75 m-auto" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="file" class="form-control w-100" name="image">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control w-100" name="title" value="<?= $title ?>" placeholder="Title">
            <?php if($errors['title']){ ?>
            <div class="alert alert-danger mt-1">
                <?= $errors['title'] ?>
            </div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <textarea name="description" class="form-control w-100" rows="5" placeholder="Description"><?= $description ?></textarea>
        </div>
        <div>
            <input type="number" class="form-control w-100" step="0.01" name="price" value="<?= $price ?>" placeholder="Price">
        </div>
        <?php if($errors['price']){ ?>
            <div class="alert alert-danger mt-1">
                <?= $errors['price'] ?>
            </div>
        <?php } ?>
        <button type="submit" class="btn btn-primary mt-3">Add</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>