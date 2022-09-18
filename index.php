<?php
    $pdo = require_once './database.php';

    $searchText = trim($_GET['searchText']) ?? '';

    if($searchText){
        $statement = $pdo->prepare('select * from products where title like :title order by create_date desc');
        $statement->bindValue(':title',"%$searchText%");
    }else
        $statement = $pdo->prepare('select * from products order by create_date desc');
    
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    
?>

    <?php include_once './views/partials/header.php' ?>
    <h2 class="text-center">All Products</h2>
    <form class="container my-4 w-75 m-auto">
        <div class="row gx-0">
            <div class="col-9 m-auto">
                <input class="form-control w-100 h-100" value="<?= $searchText ?>" type="text" placeholder="Search text" 
                name="searchText">
            </div>
            <div class="col-1 m-auto">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
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
            <td><img class="img-fluid w-50" src="<?= $image_base_url.$product['image'] ?>" alt="product_image"></td>
            <td><?= $product['title'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['create_date'] ?></td>
            <td><a href="update_product.php?id=<?= $product['id'] ?>" class="btn btn-warning">Update</a></td>
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