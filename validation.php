<?php
$title = $_POST['title'];
$image = $_FILES['image'];
$price = $_POST['price'];
$description = $_POST['description'];

if(!$title) $errors['title'] = 'Title is Required';
if(!$price) $errors['price'] = 'Price is Required';

