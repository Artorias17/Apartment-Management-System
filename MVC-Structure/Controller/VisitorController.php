<?php


class VisitorController{

    public function updateVisitor($vid=null, $visit_id=null) {
        $this->checkLogin();
        if(isset($vid) && isset($visit_id)){
            $this->showUpdateVisitor($vid, $visit_id);
        }else{
            if(isset($_POST)){
                $visitor= new Visitor();
                $vehicle= new Vehicle();

                $vid=$_SESSION["updateVisitor"]["vid"];
                $visit_id=$_SESSION["updateVisitor"]["visit_id"];
                unset($_SESSION["updateVisitor"]);

                $data=array(
                    "vid" => $vid,
                    "visit_id" => $visit_id,
                    "vname" => $_POST["name"],
                    "gender" => $_POST["gender"],
                    "address" => $_POST["address"],
                    "phone" => $_POST["phone"],
                    "arrival" => $_POST["adate"],
                    "departure" => $_POST["ddate"],
                    "reason" => $_POST["reason"],
                    "rid" => $_POST["rid"]
                );
                $visitor->set($data);
                $visitor->update();

                unset($data);
                if(isset($_POST["vehicle"])){
                    $data = array("lic" => $_POST["lic"],
                        "lot" => $_POST["lot"],
                        "vid" => $vid,
                        "visit_id" => $visit_id
                    );
                    $vehicle->set($data);
                    $vehicle->update();
                }else{
                    $data=Vehicle::fetch($vid, $visit_id);
                    $data["lic"]=$data["licence"];
                    unset($data["licence"]);
                    $vehicle->set($data);
                    $vehicle->delete();
                }
                unset($data);

                $this->redirectToDashboard();
            }
        }

    }

    public function showUpdateVisitor($vid=null, $visit_id=null){
        $visitor=Visitor::fetch($vid, $visit_id);

        $isMale= ($visitor["gender"]=="Male") ? "checked" : "";
        $isFemale= ($visitor["gender"]=="Female") ? "checked" : "";

        $arrivaldate=strtotime($visitor["visitData"]["arrival"]);
        $departuredate=strtotime($visitor["visitData"]["departure"]);

        $resident= Resident::fetchAll();
        $options="";
        foreach($resident as $key){
            $options.="<option value='{$key["rid"]}' ";
            if($key["rid"] == $visitor["visitData"]["rid"]){
                $options.= "selected";
            }
            $options.= ">{$key["rname"]}</option>";
        }

        $vehicle=Vehicle::fetch($vid, $visit_id);

        $_SESSION["updateVisitor"]["vid"]=$vid;
        $_SESSION["updateVisitor"]["visit_id"]=$visit_id;

        $dir='Apartment-Management-System/MVC-Structure/View/styles/add.css';

        require_once "./View/updateVisitor.php";
    }

    public function addVisitor(){
        $this->checkLogin();

        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            $visitor=new Visitor();
            $visitor->set($_POST);
            $visitor->insert();

            if(isset($_POST["vehicle"])){
                $vehicle= new Vehicle();
                $visit_id=$visitor->visitData["visit_id"];
                $vehicle->set(array("vid" => $visitor->vid, "lic" => $_POST["lic"], "lot" => $_POST["lot"], "visit_id" => $visit_id));
                $vehicle->insert();
            }
            unset($_POST);
            $this->redirectToDashboard();
        }else{
            $this->showAddVisitor();
        }
    }

    public function showAddVisitor(){
        if(isset($_POST["addV"])) unset($_POST);

        $resident= Resident::fetchAll();
        foreach($resident as &$r){
            $r["apt"]=Apartment::fetch($r["rid"]);
        }
        unset($r);

        $option="";
        foreach($resident as $r){
            $name=$r["rname"];
            $bno=$r["apt"]["bno"];
            $floor=$r["apt"]["floor"];
            $apt=$r["apt"]["apt_letter"];
             $option.="<option value='{$r["rid"]}'>Name-{$name}, Building No.-{$bno}, Floor-{$floor}, Apartment-{$apt}</option>";
        }

        $dir='Apartment-Management-System/MVC-Structure/View/styles/add.css';
        require_once "./View/addVisitor.php";
        die();
    }

    public function deleteVisitor($vid, $visit_id){
        $visitor= new Visitor();
        $vehicle = new Vehicle();

        $data=array("vid" => $vid,"visit_id" => $visit_id);

        $visitor->set($data);
        $vehicle->set($data);

        $visitor->delete();
        $vehicle->delete();

        $this->redirectToDashboard();
    }

    private function redirectToDashboard(){
        header("Location: ".baseURL."/");
        die();
    }

    protected function checkLogin(){
        if(!isset($_SESSION['current'])){
            header("Location: ".baseURL."/UserController/login");
            die();
        }
    }
}