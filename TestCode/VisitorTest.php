<?php


use PHPUnit\Framework\TestCase;

class VisitorTest extends TestCase{

    public $visitor, $result;

    public function setUp(): void{
        $this->visitor= $this->getMockBuilder("Visitor")
            ->disableOriginalConstructor()
            ->onlyMethods(array("wrapperQuery"))
            ->getMock();

        $this->result= $this->getMockBuilder("mysqli_result")
            ->disableOriginalConstructor()
            ->onlyMethods(array("fetch_assoc"))
            ->getMock();
    }

    public function providerTestSet(){
        return [
            [[
                "vid" => "1",
                "visit_id" =>"2",
                "vname" => "Hugh Jackman",
                "gender" => "Male",
                "address" => "10 Jane Doe Street",
                "phone" => "00123456789",
                "arrival" => "2020-08-09",
                "departure" => "2020-05-09",
                "reason" => "Visiting",
                "rid" => "10"],
            ["1", "2", "Hugh Jackman", "Male", "10 Jane Doe Street", "00123456789", "2020-08-09", "2020-05-09", "Visiting", "10"]
            ],
        ];
    }

    /**
     * @dataProvider providerTestSet
     */

    public function testSet(&$arr, &$expected){

        $this->visitor->set($arr);

        $this->assertEquals($expected[0], $this->visitor->vid);
        $this->assertEquals($expected[1], $this->visitor->visitData["visit_id"]);
        $this->assertEquals($expected[2],$this->visitor->vname);
        $this->assertEquals($expected[3],$this->visitor->gender);
        $this->assertEquals($expected[4],$this->visitor->address);
        $this->assertEquals($expected[5],$this->visitor->phone);
        $this->assertEquals($expected[6],$this->visitor->visitData["adate"]);
        $this->assertEquals($expected[7],$this->visitor->visitData["ddate"]);
        $this->assertEquals($expected[8],$this->visitor->visitData["reason"]);
        $this->assertEquals($expected[9],$this->visitor->visitData["rid"]);
    }


    public function testSearch(){

        $query= "Quelana";
        $arr=["vid"=> "69", "vname"=> "Quelana", "gender" => "Female", "address"=> "Izalith", "phone" => "08001923458"];
        $extraArr=["visit_id" => "34", "vid" => "69", "rid" => "103", "reason" => "Just Visiting", "arrival" => "2020-09-09", "departure" => "2020-09-09"];

        $this->result->expects($this->exactly(2))
            ->method("fetch_assoc")
            ->willReturnOnConsecutiveCalls($arr, NULL);

        $this->visitor->expects($this->exactly(2))
            ->method("wrapperQuery")
            ->withConsecutive(["SELECT * FROM visitor WHERE vname like '%Quelana%'"], ["SELECT * FROM visits WHERE vid=69"])
            ->willReturnOnConsecutiveCalls($this->result, $extraArr);

        $actualArray=Visitor::search($query, $this->visitor);
        $actualArray = $actualArray[0];

        $this->assertEquals("69", $actualArray["vid"]);
        $this->assertEquals("34", $actualArray["visitData"]["visit_id"]);
        $this->assertEquals("Quelana", $actualArray["vname"]);
        $this->assertEquals("Female", $actualArray["gender"]);
        $this->assertEquals("Izalith",$actualArray["address"]);
        $this->assertEquals("08001923458",$actualArray["phone"]);
        $this->assertEquals("2020-09-09",$actualArray["visitData"]["arrival"]);
        $this->assertEquals("2020-09-09",$actualArray["visitData"]["departure"]);
        $this->assertEquals("Just Visiting",$actualArray["visitData"]["reason"]);
        $this->assertEquals("103", $actualArray["visitData"]["rid"]);

    }
}
