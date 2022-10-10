
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