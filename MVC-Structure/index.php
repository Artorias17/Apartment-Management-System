<?php

//Autoload function
function load($class){
    if(file_exists("./Model/{$class}.php")) {
        include_once "./Model/{$class}.php";
    }
    else if(file_exists("./Controller/{$class}.php")){
        include_once "./Controller/{$class}.php";
    }
    else{
        include_once "core/{$class}.php";
    }
}

spl_autoload_register('load');


//Base URL constant
define("baseURL", "http://{$_SERVER['SERVER_NAME']}/Apartment-Management-System/MVC-Structure");


//App start
session_start();
$APP=new Route();
