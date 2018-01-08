<?php

namespace Calculator\Test;

require __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Calculator\Calculator;

class CalculatorTest extends TestCase{
    public function testTrueIsTrue(){
        $this->assertEquals(true, true);
    }

    public function testSumValue(){
        $calculator = new Calculator();

        $result = $calculator->sum(1,1);

        $this->assertEquals(2, $result);
    }

    public function testSomeOtherValue(){
        $calculator = new Calculator();
        
        $result = $calculator->sum(2,2);
        
        $this->assertEquals(4, $result);
    }
}
