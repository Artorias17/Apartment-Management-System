<?php

class Visitor extends DBconnect {
    public $vid;
    public $vname;
    public $gender;
    public $address;
    public $phone;
    public $visitData;

    public function set(&$arr){
        if(isset($arr['vid'])){
            $this->vid= $arr["vid"];
        }
        if(isset($arr["visit_id"])){
            $this->visitData["visit_id"] =$arr["visit_id"];
        }
        $this->vname=$arr['vname'];
        $this->gender=$arr['gender'];
        $this->address=$arr['address'];
        $this->phone=$arr['phone'];
        $this->visitData['adate']=$arr['arrival'];
        $this->visitData['ddate']=$arr['departure'];
        $this->visitData["reason"]=$arr['reason'];
        $this->visitData['rid']=$arr['rid'];
    }

    public static function search($s, $object=null){
        if($object==null){
            $object= new Visitor();
        }
        $q="SELECT * FROM visitor WHERE vname like '%{$s}%'";
        $sql=$object->wrapperQuery($q);
        $result=[];
        while($push=$sql->fetch_assoc()){
            $result[count($result)]=$push;
            $x="SELECT * FROM visits WHERE vid={$push["vid"]}";
            $x=$object->wrapperQuery($x);
            $result[count($result)-1]["visitData"]=$x;
        }
        return $result;
    }

    public static function fetchAll(){
        $sql="SELECT * FROM visitor";
        $visitorList=(new Visitor())->wrapperQuery($sql);
        $answer=array();
        $i=0;
        while($visitor=$visitorList->fetch_assoc()){
            $sql="SELECT * FROM visits WHERE vid={$visitor["vid"]}";
            $visitList=(new Visitor())->wrapperQuery($sql);
            $visitor["visitData"]=$visitList;
            $answer[$i++] = $visitor;
        }
        return $answer;
    }

    public static function fetch($vid, $visit_id){
        $q="SELECT * FROM visitor WHERE vid={$vid}";
        $visitor=(new Visitor())->wrapperQuery($q);

        $q="SELECT * FROM visits WHERE vid={$vid} AND visit_id= {$visit_id}";
        $visit=(new Visitor())->wrapperQuery($q);

        $visitor=$visitor->fetch_assoc();
        $visit=$visit->fetch_assoc();
        $visitor["visitData"]=$visit;

        return $visitor;
    }

    public function insert(){
        $x="SELECT visitor.vid FROM visitor WHERE visitor.vname='{$this->vname}' AND visitor.gender='{$this->gender}' AND visitor.address='{$this->address}' AND visitor.phone= '{$this->phone}'";
        $x=$this->wrapperQuery($x);
        if($x->num_rows==1) {
            $this->vid = ($x->fetch_assoc())["vid"];
        }
        else{
            $x="INSERT INTO visitor VALUES (NULL, '{$this->vname}', '{$this->gender}', '{$this->address}', '{$this->phone}')";
            $x=$this->wrapperQuery($x);

            $x="SELECT visitor.vid FROM visitor WHERE visitor.vname='{$this->vname}' AND visitor.gender='{$this->gender}' AND visitor.address='{$this->address}' AND visitor.phone= '{$this->phone}'";
            $x=$this->wrapperQuery($x);

            if($x->num_rows==1) {
                $this->vid = ($x->fetch_assoc())["vid"];
            }
        }
        $x="INSERT INTO visits VALUES (NULL, {$this->vid}, {$this->visitData['rid']}, '{$this->visitData["reason"]}', '{$this->visitData['adate']}', '{$this->visitData['ddate']}')";
        $x=$this->wrapperQuery($x);

        $x="SELECT MAX(visits.visit_id) AS visit_id FROM visits WHERE visits.vid= {$this->vid} AND visits.rid= {$this->visitData['rid']} AND visits.reason= '{$this->visitData['reason']}' AND visits.arrival= '{$this->visitData['adate']}' AND visits.departure= '{$this->visitData['ddate']}'";
        $x=$this->wrapperQuery($x);

        $x=$x->fetch_assoc();
        $this->visitData["visit_id"]=$x["visit_id"];
    }

    public function update(){

        $sql1="UPDATE visitor SET vname = '{$this->vname}' , gender= '{$this->gender}', address= '{$this->address}', phone= '{$this->phone}' WHERE vid={$this->vid}";
        $sql1=$this->wrapperQuery($sql1);

        $sql2= "UPDATE visits SET arrival = '{$this->visitData['adate']}', departure = '{$this->visitData['ddate']}', reason = '{$this->visitData["reason"]}', rid = {$this->visitData['rid']} WHERE visit_id={$this->visitData["visit_id"]}";
        $sql2=$this->wrapperQuery($sql2);
    }

    public function delete(){
        $x="DELETE FROM visitor WHERE visitor.vid = {$this->vid}";
        $x=$this->wrapperQuery($x);

        $x="DELETE FROM visits WHERE visit_id={$this->visitData["visit_id"]} AND vid = {$this->vid}";
        $x=$this->wrapperQuery($x);
    }

    public function wrapperQuery($q){
        return parent::query($q);
    }
}