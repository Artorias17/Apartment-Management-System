<?php

require_once "Autoloader.php";

use PHPUnit\Framework\TestCase;

class ResidentTest extends TestCase{

    public $resident;
    public $result;
    public function setUp(): void{
        $this->resident= $this->getMockBuilder("Resident")
            ->disableOriginalConstructor()
            ->onlyMethods(array("queryWrapper"))
            ->getMock();

        $this->result= $this->getMockBuilder("mysqli_result")
            ->disableOriginalConstructor()
            ->onlyMethods(array("fetch_assoc"))
            ->getMock();

    }

    public function providerTestSet(){
        return(
            array(
                array(array('rid'=> "100", 'rname' => "John Doe", 'gender' => "Male", 'phoneno' => "01013546556"), array("100", "John Doe", "Male", "01013546556")),
                array(array('rid'=> "1", 'rname' => "Jane DOE", 'gender' => "Female", 'phoneno' => "01019789699"), array("1", "Jane DOE", "Female", "01019789699")),
                array(array('rid'=> "130", 'rname' => "Jack Sparrow", 'gender' => "Male", 'phoneno' => "01016576556"), array("130", "Jack Sparrow", "Male", "01016576556")),
                array(array('rid'=> "8", 'rname' => "John Snow", 'gender' => "Female", 'phoneno' => "09013546556"), array("8", "John Snow", "Female", "09013546556"))
        ));
    }
    /**
     * @dataProvider providerTestSet
     */
    public function testSet(&$arr, &$expexted){
        $this->resident->set($arr);
        $this->assertEquals($expexted[0], $this->resident->rid);
        $this->assertEquals($expexted[1], $this->resident->rname);
        $this->assertEquals($expexted[2], $this->resident->gender);
        $this->assertEquals($expexted[3], $this->resident->phoneno);
    }

    public function providerTestUpdate(){
        $setData= $this->providerTestSet();
        foreach($setData as &$key){
            $key[2]="UPDATE resident SET rname = '{$key[1][1]}', gender = '{$key[1][2]}', phoneno = '{$key[1][3]}' WHERE resident.rid = {$key[1][0]}";
            unset($key[1]);
        }
        return $setData;
    }
    /**
     * @dataProvider providerTestUpdate
     */
    public function testUpdate(&$arr, $expString){
        $this->resident->expects($this->once())
            ->method("queryWrapper")
            ->with($expString)
            ->willReturn(true);

        $this->resident->set($arr);
        $this->resident->update();
    }

    public function providerTestInsert(){
        $set= $this->providerTestSet();
        $i=0;
        foreach($set as &$a){
            unset($a[1][0]);
            $a[2]="INSERT INTO resident (rid, rname, gender, phoneno) VALUES (NULL, '{$a[1][1]}', '{$a[1][2]}', '{$a[1][3]}')";
            $a[3]="SELECT MAX(rid) AS rid FROM resident WHERE rname='{$a[1][1]}' AND gender='{$a[1][2]}' AND phoneno= '{$a[1][3]}'";
            $a[4]=$i++;
            unset($a[1]);
        }
        return $set;
    }
    /**
     * @dataProvider providerTestInsert
     */
    public function testInsert(&$arr, $expectedStringINSERT, $expectedStringSELECT, $rid){

        $this->result->expects($this->once())
            ->method("fetch_assoc")
            ->willReturn(array("rid" => $rid));


        $this->resident->expects($this->atMost(2))
            ->method("queryWrapper")
            ->willReturnMap(
                [
                    [$expectedStringINSERT, true],
                    [$expectedStringSELECT, $this->result],
                ]
            );

        $this->resident->set($arr);
        $this->resident->insert();
        $this->assertEquals($rid, $this->resident->rid);
    }

    public function providerTestDelete(){
        $set= $this->providerTestSet();
        foreach($set as &$a){
            $a[2]="DELETE FROM resident WHERE resident.rid = {$a[1][0]}";
            unset($a[1]);
        }
        return $set;
    }
    /**
     * @dataProvider providerTestDelete
     */
    public function testDelete(&$a, $ex){
        $this->resident->expects($this->once())
            ->method("queryWrapper")
            ->with($ex)
            ->willReturn(true);

        $this->resident->set($a);
        $this->resident->delete();
    }
}
