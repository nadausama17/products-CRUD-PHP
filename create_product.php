<?php
    require_once './functions.php';
    $pdo = require_once './database.php';

    $title = '';
    $image = '';
    $price = '';
    $description = '';
    $errors = [];

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        require_once './validation.php';

        if(!is_dir('images')){
            mkdir('images');
        }

        if(empty($errors)){
            $statement = $pdo -> prepare('insert into products (title, image, price, description)
            values (:title, :image, :price, :description)');
            $statement ->bindValue(':title',$title);
            $statement ->bindValue(':price',$price);
            if($description) $statement ->bindValue(':description',$description);
            else $statement ->bindValue(':description',null);

            if($image['name']){
                require_once './upload_image.php';
                header('Location: index.php');
            }else{
                $statement ->bindValue(':image',null);
                $statement ->execute();
                header('Location: index.php');
            }
        }
    }
?>
    <?php include_once './views/partials/header.php' ?>
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