<?php

class DBconnect{
    private static String $host="localhost", $user="root", $pw="", $db="apt";

    //creating connection
    public static function connect(){
        $connection= new mysqli(self::$host,self::$user,self::$pw, self::$db);

        //check connection
        if($connection->connect_error){
            die("Connection failed because ".$connection->errno."---".$connection->connect_error);
            return null;
        }else{
            return $connection;
        }
    }
}