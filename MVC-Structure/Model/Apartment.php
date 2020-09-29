<?php


class Apartment extends DBconnect {
    public $bno, $floor, $apt_letter, $rid;

    public static function fetch($rid){
        $q="SELECT * FROM apartment WHERE apartment.rid={$rid}";
        $sql=(new Apartment())->wrapperQuery($q);
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
        $q= "INSERT INTO apartment VALUES ({$this->bno}, {$this->floor}, '{$this->apt_letter}', {$this->rid})";
        $sql= $this->wrapperQuery($q);
    }

    public function delete(){
        $sql = "DELETE FROM apartment WHERE rid={$this->rid}";
        $sql = $this->wrapperQuery($sql);
    }

    public function update(){
        $sql= "UPDATE apartment SET bno= {$this->bno}, floor= {$this->floor}, apt_letter='{$this->apt_letter}' WHERE rid= {$this->rid}";
        $sql= $this->wrapperQuery($sql);
    }

    public function wrapperQuery($q){
        return parent::query($q);
    }
}