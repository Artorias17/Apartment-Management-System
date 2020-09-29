<?php

class User extends DBconnect {

    protected int $id;
    protected string $password;
    public String $name;
    public String $userName;
    public String $gender;
    public String $dateOfBirth;
    public String $address;
    protected int $isAdmin;

    public function set(&$arr)
    {
        if (isset($arr["id"])) {
            $this->id = $arr["id"];
        }
        if (isset($arr["password"])) {
            $this->password = $arr["password"];
        }
        $this->name = $arr['name'];
        if(isset($arr["isAdmin"])){
            $this->isAdmin = $arr["isAdmin"];

        }
        $this->userName = $arr['username'];
        $this->dateOfBirth = $arr['dateOfBirth'];
        $this->gender = $arr['gender'];
        $this->address = $arr['address'];
    }
    public function insert(){
        $sql = "INSERT INTO users VALUES (NULL, '{$this->name}', '{$this->userName}', '{$this->password}', '{$this->gender}', {$this->isAdmin}, '{$this->dateOfBirth}', '{$this->address}')";
        $sql = $this->queryWrapper($sql);

        $sql = "SELECT MAX(id) AS id FROM users WHERE users.name= '{$this->name}' AND users.username= '{$this->userName}' AND users.gender= '{$this->gender}' AND users.dateOfBirth= '{$this->dateOfBirth}' AND users.address= '{$this->address}'";
        $sql = $this->queryWrapper($sql);
        $sql = $sql->fetch_assoc();
        $this->id= $sql['id'];
    }

    public function delete(){
        $sql="DELETE FROM users WHERE users.id = {$this->id}";
        $sql=$this->queryWrapper($sql);
    }

    public function update(){
        $sql="UPDATE users SET username='{$this->userName}', name = '{$this->name}', password = '{$this->password}', gender = '{$this->gender}', isAdmin = {$this->isAdmin}, dateOfBirth = '{$this->dateOfBirth}', address = '{$this->address}' WHERE users.id = {$this->id}";
        $this->queryWrapper($sql);
    }


    public static function fetch($u, $p){
        //sql query
        $sql = "SELECT * FROM users WHERE username='$u' AND password='$p'";

        //Execute the query
        $sql = (new User)->queryWrapper($sql);
        $result=[];
        while($store=$sql->fetch_assoc()){
            $result[count($result)]=$store;
        }
        return $result;
    }

    public function queryWrapper(string $q){
        return parent::query($q);
    }

    //FOR UNIT TESTING
    public function getAllData(){
        $arr=array(
            "id" =>$this->id,
            "password" => $this->password,
            "name" => $this->name,
            "username" => $this->userName,
            "gender" => $this->gender,
            "dateOfBirth" => $this->dateOfBirth,
            "address" => $this->address,
            "isAdmin" => $this->isAdmin
        );
        return $arr;
    }
}