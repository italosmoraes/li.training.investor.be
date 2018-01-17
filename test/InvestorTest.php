<?php

namespace Investor\Test;

require __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Investor\Loan;
use Investor\Investor;
use Investor\InterestCalculator;

class InvestorTest extends TestCase
{
    public function testInvestorWalletHasMoney()
    {
        $qtOfInv = 4;
        $investors = array();
        for ($i = 1; $i <= $qtOfInv; $i++) {
            $investors[$i] = new Investor("Investor ".$i);
            $investors[$i]->credit(1000.00);
        }
        for ($i = 1; $i <= $qtOfInv; $i++) {
            $this->assertEquals(1000.00, $investors[$i]->getAvailableAmount());
        }
    }
}
