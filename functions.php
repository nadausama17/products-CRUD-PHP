<?php

function get_random_directory(){
    $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $dirname = "";
    for($i=0; $i<8; $i++){
        $dirname .= $str[rand(0,strlen($str)-1)];
    }
    return $dirname;
}