<?php


class Apartment extends DBconnect {
    public $bno, $floor, $apt_letter, $rid;

    public static function fetch($rid){
        $sql=mysqli_query(self::connect(), "SELECT * FROM apartment WHERE apartment.rid={$rid}");
        $sql=$sql->fetch_assoc();
        return $sql;
    }

    public function set(&$arr){
        $this->rid= $arr["rid"];
        $this->apt_letter= $arr["apt_letter"];
        $this->bno= $arr["bno"];
        $this->floor= $arr["floor"];
    }

    public function insert(){
        $sql= mysqli_query(self::connect(), "INSERT INTO apartment VALUES ({$this->bno}, {$this->floor}, '{$this->apt_letter}', {$this->rid})");
    }

    public function delete(){
        $sql = "DELETE FROM apartment WHERE rid={$this->rid}";
        $sql = mysqli_query(self::connect(), $sql);
    }

    public function update(){
        $sql= "UPDATE apartment SET bno= {$this->bno}, floor= {$this->floor}, apt_letter='{$this->apt_letter}' WHERE rid= {$this->rid}";
        $sql= mysqli_query(self::connect(), $sql);
    }
}