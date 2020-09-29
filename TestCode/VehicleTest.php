<?php


use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase{

    public $result, $vehicle;

    public function setUp(): void{
        $this->vehicle= $this->getMockBuilder("Vehicle")
            ->disableOriginalConstructor()
            ->onlyMethods(array("queryWrapper"))
            ->getMock();

        $this->result= $this->getMockBuilder("mysqli_result")
            ->disableOriginalConstructor()
            ->onlyMethods(array("fetch_assoc"))
            ->getMock();

    }

    public function providerTestInsert(){
        $arr=[
            [["vid" => "1", "lic" => "KHA-54321", "lot" => "1", "visit_id" => "0"], "INSERT INTO vehicle (`licence`, `vid`, `lot`, `visit_id`) VALUES ('KHA-54321', 1, 1, 0)"],
            [["vid" => "2", "lic" => "KA-12-9087", "lot" => "1", "visit_id" => "0"], "INSERT INTO vehicle (`licence`, `vid`, `lot`, `visit_id`) VALUES ('KA-12-9087', 2, 1, 0)"],
            [["vid" => "3", "lic" => "GA-989898", "lot" => "1", "visit_id" => "0"], "INSERT INTO vehicle (`licence`, `vid`, `lot`, `visit_id`) VALUES ('GA-989898', 3, 1, 0)"],
            [["vid" => "-1", "lic" => "GA-12345", "lot" => "1", "visit_id" => "0"], "INSERT INTO vehicle (`licence`, `vid`, `lot`, `visit_id`) VALUES ('GA-12345', -1, 1, 0)"]
        ];
        return $arr;
    }

    /**
     * @dataProvider providerTestInsert
     */
public function testInsert(&$arr, $expectedQuery){

        $this->vehicle->expects($this->once())
            ->method("queryWrapper")
            ->with($expectedQuery)
            ->willReturn(true);

        $this->vehicle->set($arr);
        $this->vehicle->insert();
    }



    public function providerTestDelete(){
    $arr=[
        [["vid" => 9, "lic" => 1, "lot" => 3, "visit_id"=> 12], "DELETE FROM vehicle WHERE vehicle.vid = 9 AND vehicle.visit_id = 12"]];
    return $arr;
    }

    /**
     * @param $arr
     * @param $expectedQuery
     * @dataProvider providerTestDelete
     */
    public function testDelete(&$arr, $expectedQuery){

        $this->vehicle->expects($this->once())
            ->method("queryWrapper")
            ->with($expectedQuery)
            ->willReturn(true);

        $this->vehicle->set($arr);
        $this->vehicle->delete();
    }

    public function providerTestSet(){
        $arr= $this->providerTestInsert();
        $arr[0][1]='KHA-54321';
        $arr[0][2]="1";
        $arr[0][3]="1";
        $arr[0][4]="0";

        $arr[1][1]='KA-12-9087';
        $arr[1][2]="2";
        $arr[1][3]="1";
        $arr[1][4]="0";

        $arr[2][1]='GA-989898';
        $arr[2][2]="3";
        $arr[2][3]="1";
        $arr[2][4]="0";

        $arr[3][1]='GA-12345';
        $arr[3][2]="-1";
        $arr[3][3]="1";
        $arr[3][4]="0";

        return $arr;
    }
    /**
     * @param $arr
     * @param $v
     * @param $l
     * @param $lo
     * @param $vi
     * @dataProvider providerTestSet
     */
    public function testSet(&$arr, $l, $v, $lo, $vi){

        $this->vehicle->set($arr);
        $this->assertEquals($v, $this->vehicle->vid);
        $this->assertEquals($l, $this->vehicle->lic);
        $this->assertEquals($lo, $this->vehicle->lot);
        $this->assertEquals($vi, $this->vehicle->visit_id);
    }
}
