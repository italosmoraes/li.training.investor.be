<?php

namespace Investor\Test;

require __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Investor\Loan;
use Investor\Investor;
use Investor\InterestCalculator;

class LoanTest extends TestCase
{
    public function testLoanTranchesAvailable()
    {
        $loan = new Loan(
            new \DateTime('2015-10-01'),
            new \DateTime('2015-11-15')
        );
        $loan->addTranche("Tranche A", 1000, 3);
        $loan->addTranche("Tranche B", 1000, 6);
        $this->assertEquals("Tranche A", $loan->getTrancheByName("Tranche A")->getName());
        $this->assertEquals("Tranche B", $loan->getTrancheByName("Tranche B")->getName());
    }

    public function testTranchesInterestRates()
    {
        $loan = new Loan(
            new \DateTime('2015-10-01'),
            new \DateTime('2015-11-15')
        );

        $loan->addTranche("Tranche A", 1000, 3);
        $loan->addTranche("Tranche B", 1000, 6);
        $rateA = $loan->getTrancheByName("Tranche A")->getRate();
        $rateB = $loan->getTrancheByName("Tranche B")->getRate();
        $this->assertEquals(3, $rateA);
        $this->assertEquals(6, $rateB);
    }

    /* verify if tranch A and B have each 1,000 pounds available */
    public function testTranchesAmountAvailable()
    {
        $loan = new Loan(
            new \DateTime('2015-10-01'),
            new \DateTime('2015-11-15')
        );

        $loan->addTranche("Tranche A", 1000.00, 6);
        $loan->addTranche("Tranche B", 1000.00, 3);
        $amountA = $loan->getTrancheByName("Tranche A")->getAmountAvailable();
        $amountB = $loan->getTrancheByName("Tranche B")->getAmountAvailable();
        $this->assertEquals(1000.00, $amountA);
        $this->assertEquals(1000.00, $amountB);
    }

}
