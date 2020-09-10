<?php

class Route{

    //Default Controller, methods, and parameters
    protected $controller='DashboardController';
    protected $method = "dashboardView";
    protected $parameter = array();

    public function __construct(){

        //get route direction array
        $url=$this->parseURL();

        //Extract, set and recreate controller object from array
        $this->setController($url);
        $this->controller = new $this->controller();

        //Extract and set method for the controller from the array
        $this->setMethod($url);

        //Call method of the controller
        $this->parameter = (count($url)>0) ? array_values($url) : array();
        call_user_func_array([$this->controller, $this->method], $this->parameter);
    }

    //Function to split the parameter from the url and create an array of with index 0 and 1
    // being controller and method and the rest being parameters
     protected function parseURL(){
         $url=[];
        if(isset($_GET['url'])){
            $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        unset($_GET['url']);
        return $url;
    }


    //Function to set controller variable
    protected function setController(&$url){
        if (isset($url[0]) && file_exists("./Controller/" . $url[0] . ".php")) {
            $this->controller = $url[0];
            unset($url[0]);
        }
    }

    //Function to set method variable
    protected function setMethod(&$url){
        if(isset($url[1]) && method_exists($this->controller, $url[1])){
            $this->method= $url[1];
            unset($url[1]);
        }
    }
}
