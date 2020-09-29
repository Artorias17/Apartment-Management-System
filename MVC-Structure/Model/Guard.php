<?php


class Guard extends User{

    public function __construct(){
        $this->isAdmin=0;
    }
    public static function fetchAll(){
        $sql="SELECT * FROM users WHERE isAdmin = 0";
        $arr=(new Guard())->queryWrapper($sql);
        $a=[];
        while($k=$arr->fetch_assoc()){
            $a[$k["id"]]=$k;
        }
        return $a;
    }
}