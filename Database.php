<?php
namespace app;

use app\helpers\HelperFunctions;
use PDO;
use PDOException;
use app\models\Product;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Database{
    private static ?Database $DB = null;
    private PDO $pdo;
    private $host;
    private $dbname;
    private $DBusername;
    private $DBpassword;

    private function __construct()
    {
        $this->host = $_ENV['HOST'];
        $this->dbname = $_ENV['DBname'];
        $this->DBusername = $_ENV['DBusername'];
        $this->DBpassword = $_ENV['DBpassword'];
        try{
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->DBusername,$this->DBpassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo $e->getMessage();
            exit;
        }
    }

    public static function getDBObject(){
        if(!self::$DB){
            self::$DB = new Database();
        }
        return self::$DB;
    }

    public function getProducts($searchText = ''){
        if($searchText){
            $statement = $this->pdo->prepare('select * from products where title like :title order by create_date desc');
            $statement->bindValue(':title','%'.$searchText.'%');
        }else{
            $statement = $this->pdo->prepare('select * from products order by create_date desc');
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct(Product $product){
        $statement = $this->pdo->prepare('insert into products (title,price,description,image)
        values (:title,:price,:description,:image)');
        $statement->bindValue(':title',$product->title);
        $statement->bindValue(':price',$product->price);
        if($product->description){
            $statement->bindValue(':description',$product->description);
        }else{
            $statement->bindValue(':description',null);
        }

        if($product->image['tmp_name']){
            try{
                $image_path = HelperFunctions::get_random_directory().'/'.$product->image['name'];
                $statement->bindValue(':image',$image_path);
            }catch(PDOException $e){
                echo $e->getMessage();
                exit;
            }

            mkdir(dirname(__DIR__.'/public/images/'.$image_path));
            move_uploaded_file($product->image['tmp_name'],__DIR__.'/public/images/'.$image_path);
        }else{
            $statement->bindValue(':image',null);
        }
        $statement->execute();
    }

    public function updateProduct(Product $product){
        $statement = $this->pdo->prepare('update products set title=:title, price=:price
        , description=:description, image=:image where id = :id');
        $statement->bindValue(':id',$product->id);
        $statement->bindValue(':title',$product->title);
        $statement->bindValue(':price',$product->price);
        if($product->description){
            $statement->bindValue(':description',$product->description);
        }else{
            $statement->bindValue(':description',null);
        }

        if($product->image['tmp_name']){
            unlink(__DIR__.'/public/images/'.$product->oldImage);
            rmdir(dirname(__DIR__.'/public/images/'.$product->oldImage));

            try{
                $image_path = HelperFunctions::get_random_directory().'/'.$product->image['name'];
                $statement->bindValue(':image',$image_path);
            }catch(PDOException $e){
                echo $e->getMessage();
                exit;
            }

            mkdir(dirname(__DIR__.'/public/images/'.$image_path));
            move_uploaded_file($product->image['tmp_name'],__DIR__.'/public/images/'.$image_path);
        }else{
            if($product->oldImage){
                $statement->bindValue(':image',$product->oldImage);
            }else{
                $statement->bindValue(':image',null);
            }
        }
        $statement->execute();
    }

    public function getProductById($id){
        $statement = $this->pdo->prepare('select * from products where id = :id');
        $statement->bindValue(':id',$id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteProduct($id){
        $product = $this->getProductById($id);
        $statement = $this->pdo->prepare('delete from products where id = :id');
        $statement->bindValue(':id',$id);
        $statement->execute();

        unlink(__DIR__.'/public/images/'.$product['image']);
        rmdir(dirname(__DIR__.'/public/images/'.$product['image']));
    }
}