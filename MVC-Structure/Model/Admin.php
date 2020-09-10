<?php


class Admin extends User{

    public function __construct(){
        $this->isAdmin=1;
    }

    public static function fetchAll(){
        $arr=mysqli_query(DBconnect::connect(), "SELECT * FROM users WHERE isAdmin = 1");
        $a=[];
        while($k=$arr->fetch_assoc()){
            $a[$k["id"]]=$k;
        }
        return $a;
    }
}