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
            <td><img class="img-fluid w-50" src="/images/<?= $product['image'] ?>" alt="product_image"></td>
            <td><?= $product['title'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['create_date'] ?></td>
            <td><a href="/products/update?id=<?= $product['id'] ?>" class="btn btn-warning">Update</a></td>
            <form method="post" action="/products/delete">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <td><button class="btn btn-danger">Delete</button></td>
            </form>
        </tr>
        <?php } ?>    
    </tbody>
    </table>
