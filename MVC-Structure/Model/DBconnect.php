<?php

class DBconnect{
    protected String $host="localhost", $user="root", $pw="", $db="apt";

    //creating connection
    public function connect(){
        $connection= new mysqli($this->host, $this->user, $this->pw, $this->db);

        //check connection
        if($connection->connect_error){
            die("Connection failed because ".$connection->errno."---".$connection->connect_error);
            return null;
        }else{
            return $connection;
        }
    }

    public function query($q){
        $ans=mysqli_query($this->connect(), $q);
        return $ans;
    }
}