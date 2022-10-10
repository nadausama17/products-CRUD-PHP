
    <h2 class="my-5 text-center">Add Product</h2>
    <form class="form w-75 m-auto" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="file" class="form-control w-100" name="image">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control w-100" name="title" value="<?= $product['title'] ?>" placeholder="Title">
            <?php if($errors['title']){ ?>
            <div class="alert alert-danger mt-1">
                <?= $errors['title'] ?>
            </div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <textarea name="description" class="form-control w-100" rows="5" placeholder="Description"><?= $product['description'] ?></textarea>
        </div>
        <div>
            <input type="number" class="form-control w-100" step="0.01" name="price" value="<?= $product['price'] ?>" placeholder="Price">
        </div>
        <?php if($errors['price']){ ?>
            <div class="alert alert-danger mt-1">
                <?= $errors['price'] ?>
            </div>
        <?php } ?>
        <button type="submit" class="btn btn-primary mt-3">Add</button>
    </form>