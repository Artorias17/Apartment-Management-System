<?php

class UserController extends DBconnect {


    public function login(){
        $user=[];
        if(isset($_POST["send"])){
            $user= User::fetch($_POST['user'], $_POST['pass']);
        }

        //Check if it returns a single row. If so then store those in superglobal session variable
        if (count($user) == 1) {
            $user=$user[0];
            $_SESSION["current"]['id']= $user['id'];
            $_SESSION["current"]['username']= $user['username'];
            $_SESSION["current"]['name'] = $user['name'];
            $_SESSION["current"]['type'] = ($user['isAdmin']) ? "Admin" : "Guard";
            $this->redirectToDashboard();
        } else {
            $this->loginView();
        }
    }

    public function loginView(){
        $dir='Apartment-Management-System/MVC-Structure/View/styles/login.css';
        require_once "./View/login.php";
    }

    public function logout(){
        //unset
        session_destroy();
        $this->redirectToLogin();
    }

    protected function redirectToLogin(){
        header("Location: ".baseURL."/UserController/login");
        die();
    }

    protected function redirectToDashboard(){
        header("Location: ".baseURL."/");
        die();
    }

    public function addUser(){
        if($_SESSION["current"]['type']=="Admin"){
            $this->checkLogin();
            if(isset($_POST["createUser"])){
                $arr= array(
                    "name" => $_POST["name"],
                    "username" => $_POST["username"],
                    "dateOfBirth" => $_POST["dateOfBirth"],
                    "gender" => $_POST["gender"],
                    "address" => $_POST["address"],
                    "isAdmin" => $_POST["isAdmin"],
                    "password" => $_POST["password"]
                );
                if($arr["isAdmin"]){
                    $u= new Admin();
                    $u->set($arr);
                    $u->insert();
                }else{
                    $u= new Guard();
                    $u->set($arr);
                    $u->insert();
                }
                $this->redirectToDashboard();
            }
        }else{
            echo "<h1>Not authorized to perform this action</h1>";
            header("refresh: 5; url= ".baseURL."/UserController/userView");
            die();
        }
    }

    public function updateUser(){
        $this->checkLogin();
        if(isset($_POST["updateUser"])){
            $arr= array(
                "id" => $_SESSION["current"]['id'],
                "name" => $_POST["name"],
                "username" => $_POST["username"],
                "dateOfBirth" => $_POST["dateOfBirth"],
                "gender" => $_POST["gender"],
                "address" => $_POST["address"],
                "password" => $_POST["password"]
            );
            if($_SESSION["current"]['type']=="Admin"){
                $u= new Admin();
                $u->set($arr);
                $u->update();
            }else{
                $u= new Guard();
                $u->set($arr);
                $u->update();
            }
            $this->logout();
        }else{
            echo "<h1>Cannot Update User</h1>";
            header("refresh: 5; url= ".baseURL."/UserController/userView");
            die();
        }

    }

    public function deleteUser(){
        $this->checkLogin();
        $admin=Admin::fetchAll();
        $guard=Guard::fetchAll();

        $user=[];
        foreach($admin as $ad){
            if($_SESSION["current"]['id']==$ad["id"]){
                $user=$ad;
                break;
            }
        }
        foreach($guard as $g){
            if($_SESSION["current"]['id']==$g["id"]){
                $user=$g;
                break;
            }
        }

        if($user["isAdmin"]){
            if(count($admin)>1){
                $ad= new Admin();
                $ad->set($user);
                $ad->delete();
            }
            else{
                $ad= new Guard();
                $ad->set($user);
                $ad->delete();
            }
        }else{
            $g= new Guard();
            $g->set($user);
            $g->delete();
        }
        $this->logout();
    }

    public function fillTable(&$arr){
        $data="";
        foreach ($arr as $key) {
            $data.="<tr>"
                ."<td>".$key["username"]."</td>"
                ."<td>".$key["name"]."</td>"
                ."<td>".$key["gender"]."</td>"
                ."<td>".$key["address"]."</td>"
                ."<td>".$key["dateOfBirth"]."</td></tr>";
        }
        return $data;
    }

    public function userView(){
        if(isset($_POST["userViewRedirect"])){
            unset($_POST["userViewRedirect"]);
            header("Location: ".baseURL."/UserController/userView");
            die();
        }
        $this->checkLogin();
        $admin=Admin::fetchAll();
        $guard=Guard::fetchAll();

        $adminData= $this->fillTable($admin);
        $guardData= $this->fillTable($guard);

        $user=[];
        foreach($admin as $ad){
            if($_SESSION["current"]['id']==$ad["id"]){
                $user=$ad;
                break;
            }
        }
        foreach($guard as $g){
            if($_SESSION["current"]['id']==$g["id"]){
                $user=$g;
                break;
            }
        }
        $Male = ($user['gender']=="Male") ? "checked" : "";
        $Female = ($user['gender']=="Female") ? "checked" : "";
        $date= strtotime($user["dateOfBirth"]);
        $isAdmin= ($user["isAdmin"]==1) ? "checked" : "";
        $isGuard= ($user["isAdmin"]==0) ? "checked" : "";

        $dir1='Apartment-Management-System/MVC-Structure/View/styles/add.css';
        $dir2='Apartment-Management-System/MVC-Structure/View/styles/dash.css';
        require_once "./View/userView.php";
    }

    protected function checkLogin(){
        if(!isset($_SESSION['current'])){
            header("Location: ".baseURL."/UserController/login");
            die();
        }
    }
}
