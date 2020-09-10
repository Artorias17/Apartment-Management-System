<?php


class ResidentController{

    private function redirectToDashboard(){
        header("Location: ".baseURL."/");
        die();
    }

    public function addResident(){
        if(isset($_POST["addR"])){
            $this->checkLogin();
            $this->showAddResident();
        }else{
            if(isset($_POST["submit"])){
                $resident =new Resident();
                $apt= new Apartment();
                $data=array(
                    "rname" => $_POST["rname"],
                    "gender" => $_POST["gender"],
                    "phoneno" => $_POST["phone"],
                );

                $resident->set($data);
                $resident->insert();

                unset($data);

                $data=array(
                    "bno" => $_POST["bno"],
                    "floor" => $_POST["floor"],
                    "apt_letter" => $_POST["aptLetter"],
                    "rid" => $resident->rid
                );

                $apt->set($data);
                $apt->insert();

                unset($data);
                unset($_POST);

                $this->redirectToDashboard();
            }
        }
    }

    private function showAddResident(){
        $dir='Apartment-Management-System/MVC-Structure/View/styles/add.css';
        require_once "./View/addResident.php";
    }

    public function updateResident($rid=null){
        $this->checkLogin();
        if(!(isset($rid))){
            $rid=$_SESSION["updateResident"];
            unset($_SESSION["updateResident"]);

            $res= new Resident();
            $apt= new Apartment();

            $data= array(
                "rid" => $rid,
                "rname" => $_POST["name"],
                "gender" => $_POST["gender"],
                "phoneno" => $_POST["phone"]
            );
            $res->set($data);
            $res->update();

            unset($data);
            $data= array(
                "rid" => $rid,
                "bno" => $_POST["bno"],
                "floor" => $_POST["floor"],
                "apt_letter" => $_POST["aptLetter"]
            );
            $apt->set($data);
            $apt->update();

            $this->redirectToDashboard();
        }else{
            $this->showUpdateResident($rid);
        }

    }

    public function deleteResident($rid){
        $res=new Resident();
        $data= Resident::fetch($rid);
        $res->set($data);
        $res->delete();

        $apt=new Apartment();
        $data= Apartment::fetch($rid);
        $apt->set($data);
        $apt->delete();

        unset($data);

        $visitorAllDelete= Visitor::fetchAll();
        foreach ($visitorAllDelete as $v){
            $v=$v["visitData"]->fetch_assoc();

            if($v["rid"]==$rid){
                $data= array(
                    "vid" => $v["vid"],
                    "visit_id" => $v["visit_id"]
                );

                $delete= new Visitor();
                $delete->set($data);
                $delete->delete();

                $delete= new Vehicle();
                $delete->set($data);
                $delete->delete();
            }
        }

        $this->redirectToDashboard();
    }

    private function showUpdateResident($rid){
        $resident=Resident::fetch($rid);
        $apt=Apartment::fetch($rid);
        $_SESSION["updateResident"]=$rid;
        $isMale= ($resident["gender"]=="Male") ? "checked" : "";
        $isFemale= ($resident["gender"]=="Female") ? "checked" : "";
        $dir='Apartment-Management-System/MVC-Structure/View/styles/add.css';
        require_once "./View/updateResident.php";
    }

    private function checkLogin(){
        if(!isset($_SESSION['current'])){
            header("Location: ".baseURL."/UserController/login");
            die();
        }
    }
}