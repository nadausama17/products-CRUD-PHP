<?php
    require_once realpath(__DIR__ . '/vendor/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    $HOST = $_ENV['HOST'];
    $dbname = $_ENV['DBname'];
    $image_base_url = "http://localhost/PHPCrud/images/";

    try{
        $pdo = new PDO("mysql:host=$HOST;dbname=$dbname",$_ENV['DBusername'],$_ENV['DBpassword']);

        $statement = $pdo->prepare('select * from products');
        $statement->execute();

        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $err){
        echo $err;
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
    <link rel="stylesheet" href="./CSS/styles.css">
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
    <h2 class="text-center">All Products</h2>
    <table class="table">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Created Date</th>
      <th scope="col" class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($products as $product){?>
        <tr>
            <th scope="row"><?= $product['id'] ?></th>
            <td><img class="img-fluid" src="<?= $image_base_url.$product['image'] ?>" alt="product_image"></td>
            <td><?= $product['title'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['create_date'] ?></td>
            <td><button class="btn btn-warning">Update</button></td>
            <form method="post" action="delete_product.php">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <td><button class="btn btn-danger">Delete</button></td>
            </form>
        </tr>
        <?php } ?>    
    </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>