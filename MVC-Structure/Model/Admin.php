<?php


class Admin extends User{

    public function __construct(){
        $this->isAdmin=1;
    }

    public static function fetchAll(){
        $q="SELECT * FROM users WHERE isAdmin = 1";
        $arr=(new Admin())->queryWrapper($q);
        $a=[];
        while($k=$arr->fetch_assoc()){
            $a[$k["id"]]=$k;
        }
        return $a;
    }

}