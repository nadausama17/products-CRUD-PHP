<?php
namespace app\models;

use app\Database;

class Product{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?array $image = null;
    public ?string $oldImage = null;
    public ?float $price = null;

    public function load($data){
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->image = $data['image'] ?? null;
        $this->price = (float)$data['price'] ?? null;
        $this->oldImage = $data['oldImage'] ?? null;
    }

    public function save(){
        $errors = [];

        if(!$this->title){
            $errors['title'] = 'Title is required';
        }
        if(!$this->price){
            $errors['price'] = 'Price is required';
        }

        if(empty($errors)){
            if(!is_dir('../public/images')){
                mkdir('../public/images');
            }

            $db = Database::getDBObject();

            if($this->id){
                $db->updateProduct($this);
            }else{
                $db->createProduct($this);
            }
        }

        return $errors;
    }
}