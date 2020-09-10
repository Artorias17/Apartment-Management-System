<?php

class DashboardController{

    public function fillVisitorTable(&$data, &$details, $visitor, $vehicle){
        foreach ($visitor as $key) {
            $data.="<tr class='visitorData{$key["vid"]}'>";
            $data.="<td>{$key["vname"]}</td>";
            $data.="<td>{$key["gender"]}</td>";
            $data.="<td>{$key["address"]}</td>";
            $data.="<td>{$key["phone"]}</td>";
            $data.='<td><div class="opt"><input class="b" name="details" type="button" value="Details" style= "transform: translate(-50%, 0%)" onclick="'."showD({$key["vid"]})".'"></div></td></tr>';

            while($visit=$key["visitData"]->fetch_assoc()){
                $details.="<tr class='visitData{$key["vid"]}'>";
                $details.="<td>{$visit["arrival"]}</td>";
                $details.="<td>{$visit["departure"]}</td>";
                $details.="<td>{$visit["reason"]}</td>";
                $transportDetailsToBeFilled="<td>Not Available</td><td>Not Available</td>";
                foreach ($vehicle as $transport) {
                    if($transport["vid"]==$visit["vid"] && $transport["visit_id"]==$visit["visit_id"]){
                        $transportDetailsToBeFilled="<td>{$transport["licence"]}</td>";
                        $transportDetailsToBeFilled.="<td>{$transport["lot"]}</td>";
                    }
                }
                $details.=$transportDetailsToBeFilled;
                $details.="<td><a class='operation' href='".baseURL."/VisitorController/updateVisitor/{$key["vid"]}/{$visit["visit_id"]}"."'>Update</a></td>";
                $details.="<td><a class='operation' href='".baseURL."/VisitorController/deleteVisitor/{$key["vid"]}/{$visit["visit_id"]}"."'>Delete</a></td></tr>";
            }
        }
    }

    public function fillResidentTable(&$data, $resident, $visitor){
        $arr=[];
        foreach($visitor as $v){
            $v=$v["visitData"]->fetch_assoc();
            foreach ($resident as $r){
                if($r["rid"] == $v["rid"]){
                    if(!isset($arr[$r["rid"]])){
                        $arr[$r["rid"]]="";
                    }
                    $arr[$r["rid"]].="visitData".$v["vid"]." ";
                }
            }
        }
        $data="";
        foreach($resident as $key){
            $apt= Apartment::fetch($key["rid"]);
            $data.="<tr class='residentData{$key["rid"]} {$arr[$key["rid"]]}' ><td>"
                .$key["rname"]."</td><td>"
                .$key["gender"]."</td><td>"
                .$key["phoneno"]."</td><td>"
                .$apt["bno"]."</td><td>"
                .$apt["floor"]."</td><td>"
                .$apt["apt_letter"]."</td>";

            $data.="<td><a class='operation' href='".baseURL."/ResidentController/updateResident/{$key["rid"]}'>Update</a></td><td>"
                . "<a class='operation' href='".baseURL."/ResidentController/deleteResident/{$key["rid"]}'>Delete</a></td></tr>";
        }

    }

    public function search($s){
        $visitorSearch=Visitor::search($s);
        $resultTableBlock= "<div class='tableblock' id='S'><p class='tt'>Search Results</p>";
        if(!empty($visitorSearch)){
            $data="";
            $details="";
            $this->fillVisitorTable($data, $details, $visitorSearch, []);
            unset($details);

            $resultTableBlock.= "<table class='tab'><thead><tr>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Details</th>
                                    </tr></thead><tbody>$data</tbody></table></div>";
        }else{
            $resultTableBlock.= "<p class='tt'>Found Nothing</p></div>";
        }
        unset($_POST);
        return $resultTableBlock;
    }


    public function dashboardView(){
        $this->checkLogin();

        $data="";
        $details="";
        $residentData="";
        $search="";
        $this->fillVisitorTable($data, $details, Visitor::fetchAll(), Vehicle::fetchAll());

        $this->fillResidentTable($residentData, Resident::fetchAll(), Visitor::fetchAll());

        if(isset($_POST["go"])){
            $search=$this->search($_POST["search"]);
            unset($_POST);
        }

        $dir='Apartment-Management-System/MVC-Structure/View/styles/dash.css';
        require_once  "./View/dashboard.php";
    }

    public function redirectToDashboard(){
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