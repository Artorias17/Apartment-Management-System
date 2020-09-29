<?php
include_once "Autoloader.php";

use PHPUnit\Framework\TestCase;

class ApartmentTest extends TestCase{

    public array $database;
    public $apt;

    public function setUp(): void
    {
        $this->apt =$del= $this->getMockBuilder("Apartment")
            ->disableOriginalConstructor()
            ->onlyMethods(array("wrapperQuery"))
            ->getMock();

        $this->database= array(
            array( "bno"=>4,  "floor"=>1,  "apt_letter"=>"A",  "rid"=>100),
            array( "bno"=>4,  "floor"=>3,  "apt_letter"=>"B",  "rid"=>103),
            array( "bno"=>13,  "floor"=>4,  "apt_letter"=>"G",  "rid"=>107),
            array( "bno"=>13,  "floor"=>6,  "apt_letter"=>"A",  "rid"=>108),
        );
    }

    public function providerTestDelete(){
        return array(
            array(47, "DELETE FROM apartment WHERE rid=47"),
            array(10, "DELETE FROM apartment WHERE rid=10"),
            array(-1, "DELETE FROM apartment WHERE rid=-1"),
            array(-0, "DELETE FROM apartment WHERE rid=0"),
        );
    }

    /**
     * @dataProvider providerTestDelete
     */
    public function testDelete($rid, $expectedString){

        $this->apt->expects($this->once())
            ->method("wrapperQuery")
            ->with($expectedString);

        $this->apt->rid=$rid;
        $this->apt->delete();
    }

    public function providerTestSet(){
        return array(
            array(array( "bno"=>"1",  "floor"=>"3",  "apt_letter"=>"A",  "rid"=>"3"), "1", "3", "A", "3"),
            array(array( "bno"=>"2",  "floor"=>"1",  "apt_letter"=>"B",  "rid"=>"2"), "2", "1", "B", "2"),
            array(array( "bno"=>"1",  "floor"=>"6",  "apt_letter"=>"C",  "rid"=>"2"), "1", "6", "C", "2"),
            array(array( "bno"=>"10",  "floor"=>"10", "apt_letter"=>"D",  "rid"=>"1"), "10", "10", "D", "1"),
            array(array( "bno"=>"",  "floor"=>"", "apt_letter"=>"",  "rid"=>""), "", "", "", ""),
        );
    }
    /**
     * @dataProvider providerTestSet
     */
    public function testSet(&$arr, $b, $f, $a, $r){

        $apt = new Apartment();
        $apt->set($arr);
        $this->assertEquals($b, $apt->bno);
        $this->assertEquals($f, $apt->floor);
        $this->assertEquals($a, $apt->apt_letter);
        $this->assertEquals($r, $apt->rid);
    }


    public function providerTestUpdate(){
        $arr= $this->providerTestSet();
        foreach ($arr as &$v){
            $v[1]="UPDATE apartment SET bno= {$v[0]['bno']}, floor= {$v[0]['floor']}, apt_letter='{$v[0]['apt_letter']}' WHERE rid= {$v[0]['rid']}";
            unset($v[2]);
            unset($v[3]);
            unset($v[4]);
        }
        return $arr;
    }

    /**
     * @dataProvider providerTestUpdate
     */
    public function testUpdate($arr, $expectedString){

        $this->apt->expects($this->once())
            ->method("wrapperQuery")
            ->with($expectedString);

        $this->apt->set($arr);

        $this->apt->update();
    }


    public function providerTestInsert(){
        $arr= $this->providerTestUpdate();
        foreach ($arr as &$v){
            $v[1]="INSERT INTO apartment VALUES ({$v[0]["bno"]}, {$v[0]["floor"]}, '{$v[0]["apt_letter"]}', {$v[0]["rid"]})";
        }
        return $arr;
    }
    /**
     * @param $arr
     * @param $expectedString
     * @dataProvider providerTestInsert
     */
    public function testInsert(&$arr, $expectedString){
        $this->apt->expects($this->once())
            ->method("wrapperQuery")
            ->with($expectedString);

        $this->apt->set($arr);
        $this->apt->insert();
    }

    public function tearDown(): void{
        unset($this->apt);
        unset($this->database);
    }
}
