<?php

namespace Investor\Test;

require __DIR__.'/../vendor/autoload.php';

use Investor\DomainException;
use PHPUnit\Framework\TestCase;
use Investor\Loan;
use Investor\Investor;
use Investor\InterestCalculator;

class InvestScenarioTest extends TestCase
{
    /**
     * @test
     */
    public function acceptanceTest()
    {
        $investor1 = new Investor('Investor 1');
        $investor1->credit(1000.00);

        $investor2 = new Investor('Investor 2');
        $investor2->credit(1000.00);

        $investor3 = new Investor('Investor 3');
        $investor3->credit(1000.00);

        $investor4 = new Investor('Investor 4');
        $investor4->credit(1000.00);

        $loan = new Loan(
            new \DateTime('2015-10-01'),
            new \DateTime('2015-11-15')
        );
        $loan->addTranche("Tranche A", 1000.00, 3);
        $loan->addTranche("Tranche B", 1000.00, 6);

        $trancheA = $loan->getTrancheByName('Tranche A');
        $trancheB = $loan->getTrancheByName('Tranche B');

        $date = new \DateTime('2015-10-03');
        $this->assertTrue($investor1->invest($trancheA, 1000.00, $date));

        $date = new \DateTime('2015-10-04');
        try {
            $investor2->invest($trancheA, 1.00, $date);
            $this->fail();
        } catch (DomainException $e) {

        }

        $date = new \DateTime('2015-10-10');
        $this->assertTrue($investor3->invest($trancheB, 500.00, $date));

        $date = new \DateTime('2015-10-25');
        try {
            $investor4->invest($trancheB, 1100.00, $date);
            $this->fail();
        } catch (DomainException $e) {

        }

        $expectedEarningsInvestor1 = 28.06;
        $expectedEarningsInvestor3 = 21.29;

        $startDate = new \DateTime('2015-10-01');
        $endDate = new \DateTime('2015-10-31');

        $loan->calculateInterest($startDate, $endDate);

        $this->assertEquals($expectedEarningsInvestor1, $investor1->interestEarned());
        $this->assertEquals($expectedEarningsInvestor3, $investor3->interestEarned());
    }

}
