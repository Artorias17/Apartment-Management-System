<?php

class Resident extends DBconnect {
    public $rid, $rname, $gender, $phoneno;

    public function set(&$arr){
        if(isset($arr['rid'])){
            $this->rid=$arr['rid'];
        }
        $this->rname=$arr['rname'];
        $this->gender=$arr['gender'];
        $this->phoneno=$arr['phoneno'];
    }

    public static function fetchAll(){
        $arr=mysqli_query(self::connect(), "SELECT * FROM resident");

        $assocArray=array();
        while($n=$arr->fetch_assoc()){
            $assocArray[$n['rid']]=$n;
        }
        return $assocArray;
    }

    public static function fetch($rid){
        $sql="SELECT * FROM resident WHERE rid={$rid}";
        $sql=mysqli_query(DBconnect::connect(), $sql);
        return $sql->fetch_assoc();
    }

    public function delete(){
        $sql= "DELETE FROM resident WHERE resident.rid = {$this->rid}";
        $sql= mysqli_query(self::connect(), $sql);
    }

    public function update(){
        $sql="UPDATE resident SET rname = '{$this->rname}', gender = '{$this->gender}', phoneno = '{$this->phoneno}' WHERE resident.rid = {$this->rid}";
        $sql=mysqli_query(self::connect(), $sql);
    }

    public function insert(){
        $x="INSERT INTO resident (rid, rname, gender, phoneno) VALUES (NULL, '{$this->rname}', '{$this->gender}', '{$this->phoneno}')";
        $x=mysqli_query(self::connect(), $x);

        $x="SELECT MAX(rid) AS rid FROM resident WHERE rname='{$this->rname}' AND gender='{$this->gender}' AND phoneno= '{$this->phoneno}'";
        $x=mysqli_query(self::connect(), $x);

        $x= $x->fetch_assoc();
        $this->rid=$x["rid"];
    }

}