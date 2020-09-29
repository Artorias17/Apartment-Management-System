<?php

class Vehicle extends DBconnect {
    public $vid, $lic, $lot, $visit_id;

    public function set($arr){
        $this->vid=$arr["vid"];
        $this->lic=$arr["lic"];
        $this->lot=$arr["lot"];
        $this->visit_id=$arr["visit_id"];
    }

    public static function fetchAll(){
        $sql="SELECT * FROM vehicle";
        $sql=(new Vehicle())->queryWrapper($sql);
        $RETURN=[];
        while(count($RETURN)!=$sql->num_rows){
            $RETURN[count($RETURN)]=$sql->fetch_assoc();
        }
        return $RETURN;
    }

    public static function fetch($vid, $visit_id){
        $sql="SELECT * FROM vehicle WHERE vehicle.visit_id = {$visit_id} AND vehicle.vid = {$vid}";
        $sql=(new Vehicle())->queryWrapper($sql);
        return $sql->fetch_assoc();
    }

    public function insert(){
        $qu= "INSERT INTO vehicle (`licence`, `vid`, `lot`, `visit_id`) VALUES ('{$this->lic}', {$this->vid}, {$this->lot}, {$this->visit_id})";
        $qu= $this->queryWrapper($qu);
    }

    public function update(){
        $array= self::fetch($this->vid, $this->visit_id);
        if(isset($array)){
            $q="UPDATE vehicle SET licence = '{$this->lic}', lot = {$this->lot} WHERE vehicle.vid = {$this->vid} AND vehicle.visit_id = {$this->visit_id}";
            $q=$this->queryWrapper($q);
        }else{
            $this->insert();
        }
    }


    public function delete(){
        $q="DELETE FROM vehicle WHERE vehicle.vid = {$this->vid} AND vehicle.visit_id = {$this->visit_id}";
        $q= $this->queryWrapper($q);
    }

    public function queryWrapper($q){
        return parent::query($q);
}
}