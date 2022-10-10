<?php
namespace app;

class Router{
    private array $getRoutes;
    private array $postRoutes;

    public function get($url,$fn){
        $this->getRoutes[$url] = $fn;
    }

    public function post($url,$fn){
        $this->postRoutes[$url] = $fn;
    }

    public function resolve(){
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $fn = $this->getRoutes[$currentUrl];
            call_user_func($fn,$this);
        }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $fn = $this->postRoutes[$currentUrl];
            call_user_func($fn,$this);
        }
    }

    public function renderView($view,$params=[]){
        foreach($params as $key=>$value){
            $$key = $value;
        }
        ob_start();
        include_once __DIR__.'/public/views/'.$view.'.php';
        $content = ob_get_clean();
        include_once __DIR__.'/public/views/_layout.php';
    }
}