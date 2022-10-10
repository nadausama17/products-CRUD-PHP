<?php
namespace app\controllers;

use app\Database;
use app\models\Product;
use app\Router;

class ProductsController{
    
    public static function index(Router $router){
        $searchText = $_GET['searchText'] ?? '';
        $db = Database::getDBObject();
        $products = $db->getProducts($searchText);
        $router->renderView('products/index',[
            'products' => $products,
            'searchText' => $searchText
        ]);
    }

    public static function create(Router $router){
        $errors = [];
        $productData = [
            'title' => '',
            'image' => '',
            'price' => '',
            'description' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $productData['title'] = $_POST['title'] ?? '';
            $productData['image'] = $_FILES['image'] ?? '';
            $productData['price'] = $_POST['price'] ?? '';
            $productData['description'] = $_POST['description'] ?? '';

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
            if(empty($errors)){
                header('Location: /');
            }
        }

        $router->renderView('products/create_product',[
            'product' => $productData,
            'errors' => $errors
        ]);
    }

    public static function update(Router $router){
        $id = $_GET['id'] ?? null;
        $errors = [];
        $db = Database::getDBObject();
        $productData = $db->getProductById($id);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $productData['title'] = $_POST['title'] ?? '';
            $productData['oldImage'] = $productData['image'] ?? '';
            if($_FILES['image']){
                $productData['image'] = $_FILES['image'];
            }
            $productData['price'] = $_POST['price'] ?? '';
            $productData['description'] = $_POST['description'] ?? '';

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
            if(empty($errors)){
                header('Location: /');
            }
        }

        $router->renderView('products/update_product',[
            'product' => $productData,
            'errors' => $errors
        ]);
    }

    public static function delete(){
        $id = $_POST['id'] ?? null;
        if($id){
            $db = Database::getDBObject();
            $db->deleteProduct($id);
        }
        header('Location: /');
    }
}