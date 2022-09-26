<?php
    require_once '../../functions.php';
    $pdo = require_once '../../database.php';

    $id = $_GET['id'] ?? null;
    if(!$id){
        header('Location: index.php');
    }

    $statement = $pdo->prepare('select * from products where id= :id');
    $statement->bindValue(':id',$id);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require_once '../../validation.php';

        $errors = [];

        if(empty($errors)){
            $statement = $pdo->prepare('update products set title= :title, price= :price,
            description= :description, image= :image where id= :id');
            $statement->bindValue(':id',$id);
            $statement->bindValue(':title',$title);
            $statement->bindValue(':price',$price);
            $statement->bindValue(':description',$description);

            if($image['tmp_name']){
                unlink('../images/'.$product['image']);
                rmdir('../images/'.dirname($product['image']));

                if(!is_dir('../images')){
                    mkdir('../images');
                }

                require_once '../../upload_image.php';

                header('Location: index.php');
            }else{
                $statement->bindValue(':image',$product['image']);
                $statement->execute();

                header('Location: index.php');
            }
        }
    }
?>

    <?php include_once '../../views/partials/header.php' ?>
    <h3 class="my-3 text-center">Update Product</h3>

    <div class="text-center mb-3">
        <img class="updateimage" src="/images/<?= $product['image'] ?>" alt="product_image">
    </div>

    <form class="form w-75 m-auto" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="file" class="form-control w-100" name="image">
            <p>The current image is <?= explode("/",$product['image'])[1] ?></p>
        </div>
        <div class="mb-3">
            <label>Title:</label>
            <input type="text" class="form-control w-100" name="title" value="<?= $product['title'] ?>">
            <?php if($errors['title']){ ?>
            <div class="alert alert-danger mt-1">
                <?= $errors['title'] ?>
            </div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control w-100" rows="5"><?= $product['description'] ?></textarea>
        </div>
        <div>
            <label>Price:</label>
            <input type="number" value="<?= $product['price'] ?>" class="form-control w-100" step="0.01" name="price" value="<?= $price ?>">
        </div>
        <?php if($errors['price']){ ?>
            <div class="alert alert-danger mt-1">
                <?= $errors['price'] ?>
            </div>
        <?php } ?>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>