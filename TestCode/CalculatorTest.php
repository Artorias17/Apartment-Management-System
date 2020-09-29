<?php
require_once "Autoloader.php";
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase{

    private $calculator;

    protected function setUp() : void
    {

        $this->calculator = new Calculator();
    }

    protected function tearDown() : void
    {
        $this->calculator = NULL;
    }

    public function testAdd()
    {
        $result = $this->calculator->add(1, 8);
        $this->assertEquals(8, $result);
    }

    public function  testSubtract(){

    }
}
