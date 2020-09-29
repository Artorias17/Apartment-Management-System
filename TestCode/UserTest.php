<?php
include_once "Autoloader.php";

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase{

    public $user;

    public function setUp(): void{
        $this->user = $this->getMockBuilder("User")
            ->disableOriginalConstructor()
            ->onlyMethods(array("queryWrapper"))
            ->getMock();

    }

    public function providerTestDelete(){
        return array(
            array("-1", "DELETE FROM users WHERE users.id = -1"),
            array("0", "DELETE FROM users WHERE users.id = 0"),
            array("2", "DELETE FROM users WHERE users.id = 2"),
            array("100", "DELETE FROM users WHERE users.id = 100"),
        );
    }

    /**
     * @param $id
     * @param $expectedString
     * @dataProvider providerTestDelete
     */
    public function testDelete($id, $expectedString){

        $this->user->expects($this->once())
            ->method("queryWrapper")
            ->with($expectedString);

        $arr= array("id" => $id, "username" =>"", "name" => "" ,"dateOfBirth" => "", "gender" => "", "address" => "");
        $this->user->set($arr);

        $this->user->delete();

    }

    public function providerTestInsert(){
        $a= array(
            array("x", "xx", "pwd1", "Male" , "0", "1920-09-08", "12 Jane Street, Doe", "1"),
            array("y", "yy", "pwd2", "Female" , "1", "1920-09-07", "20 Jane Street, Doe", "2"),
            array("y", "zz", "pwd3", "Male" , "1", "1920-05-08", "12 John Street, Doe", "3"),
            array("a", "aa", "pwd4", "Female" , "0", "1990-09-01", "21 John Street, Doe", "4"),
        );
        $returnARR=array();
        foreach($a as $b){
            $arr = array(
                "name" => $b[0],
                "username" => $b[1],
                "password" => $b[2],
                "gender" => $b[3],
                "isAdmin" => $b[4],
                "dateOfBirth" => $b[5],
                "address" => $b[6]
            );
            $insert = "INSERT INTO users VALUES (NULL, '{$arr["name"]}', '{$arr["username"]}', '{$arr["password"]}', '{$arr["gender"]}', {$arr["isAdmin"]}, '{$arr["dateOfBirth"]}', '{$arr["address"]}')";
            $select = "SELECT MAX(id) AS id FROM users WHERE users.name= '{$arr["name"]}' AND users.username= '{$arr["username"]}' AND users.gender= '{$arr["gender"]}' AND users.dateOfBirth= '{$arr["dateOfBirth"]}' AND users.address= '{$arr["address"]}'";

            $returnARR[count($returnARR)]=array($arr, $insert, $select, $b[7]);
        }
        return $returnARR;
    }

    /**
     * @dataProvider providerTestInsert
     */
    public function testInsert(&$arr, $insert, $select, $returnID){

        $mysqli_result= $this->getMockBuilder("mysqli_result")
            ->disableOriginalConstructor()
            ->onlyMethods(array("fetch_assoc"))
            ->getMock();

        $mysqli_result->expects($this->once())
            ->method("fetch_assoc")
            ->willReturn(array("id" => $returnID));

        //willReturnMap the very last argument is return value.
        //The rest are expected arguments
        $this->user->expects($this->atLeast(2))
            ->method("queryWrapper")
            ->willReturnMap(
                array(
                    array($insert, true),
                    array($select, $mysqli_result)
                )
            );

        $this->user->set($arr);
        $this->user->insert();
        $this->assertEquals($returnID, ($this->user->getAllData())["id"]);
    }


    public function providerTestUpdate(){
        $a=$this->providerTestInsert();
        $i=0;
        foreach ($a as &$arr){
            $arr[0]["id"]=$i++;
            $arr[1]="UPDATE users SET username='{$arr[0]["username"]}', name = '{$arr[0]["name"]}', password = '{$arr[0]["password"]}', gender = '{$arr[0]["gender"]}', isAdmin = {$arr[0]["isAdmin"]}, dateOfBirth = '{$arr[0]["dateOfBirth"]}', address = '{$arr[0]["address"]}' WHERE users.id = {$arr[0]["id"]}";
            unset($arr[2]);
            unset($arr[3]);
            unset($arr[4]);
        }
        return $a;
    }

    /**
     * @dataProvider providerTestUpdate
     */
    public function testUpdate(&$arr, $expectedQuery){
        $this->user->expects($this->once())
            ->method("queryWrapper")
            ->with($expectedQuery);

        $this->user->set($arr);
        $this->user->update();
    }

    public function providerTestSet(){
        $a= array(
            array("x", "xx", "pwd1", "Male" , "0", "1920-09-08", "12 Jane Street, Doe", "1"),
            array("y", "yy", "pwd2", "Female" , "1", "1920-09-07", "20 Jane Street, Doe", "2"),
            array("y", "zz", "pwd3", "Male" , "1", "1920-05-08", "12 John Street, Doe", "3"),
            array("a", "aa", "pwd4", "Female" , "0", "1990-09-01", "21 John Street, Doe", "4"),
        );
        $c=array();
        foreach($a as &$b) {
            $c[count($c)] = array(array(
                "name" => $b[0],
                "username" => $b[1],
                "password" => $b[2],
                "gender" => $b[3],
                "isAdmin" => $b[4],
                "dateOfBirth" => $b[5],
                "address" => $b[6],
                "id" => $b[7]
            ));
        }
        return $c;
    }

    /**
     * @dataProvider providerTestSet
     */
    public function testSet(&$expectedArray){
        $this->user->set($expectedArray);
        $actualArray=$this->user->getAllData();

        $this->assertEquals(count($expectedArray), count($actualArray));

        foreach($expectedArray as $key1 => $value1){
            foreach($actualArray as $key2 => $value2){
                if($key1==$key2){
                    $this->assertEquals($value1, $value2);
                    break;
                }
            }
        }
    }
}
