<?php

namespace Investor\Test;

require __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Investor\Loan;
use Investor\Investor;
use Investor\Wallet;
use DateTime;
use Investor\InterestCalculator;

class InvestScenarioTest extends TestCase {


/*
 * - Given a loan (start 01/10/2015 end 15/11/2015). 
 */
    public function testLoanStartDate(){
        $loan = new Loan();
        $this->assertEquals("01/10/2015", $loan->getStartDate());
    }

    public function testLoanEndDate(){
        $loan = new Loan();
        $this->assertEquals("15/11/2015", $loan->getEndDate());
    }

/*
* - Given the loan has 2 tranches called A and B (3% and 6% monthly interest rate) each with
* 1,000 pounds amount available.
*/

    /* verify if loan has 2 tranches */
    public function testLoanTranchesAvailable(){
        $loan = new Loan();
        $loan->addTranche("Tranche A");
        $loan->addTranche("Tranche B");
        $this->assertEquals("Tranche A", $loan->getTrancheByName("Tranche A")->getName());
        $this->assertEquals("Tranche B", $loan->getTrancheByName("Tranche B")->getName());
    }

    /* verify if tranch A has 3% interest rate and tranche B has 6% rate */
    public function testTranchesInterestRates(){
        $loan = new Loan();
        $loan->addTranche("Tranche A");
        $loan->addTranche("Tranche B");
        $loan->getTrancheByName("Tranche A")->setRate(3);
        $loan->getTrancheByName("Tranche B")->setRate(6);
        $rateA = $loan->getTrancheByName("Tranche A")->getRate();
        $rateB = $loan->getTrancheByName("Tranche B")->getRate();
        $this->assertEquals(3, $rateA);
        $this->assertEquals(6, $rateB);
    }

    /* verify if tranch A and B have each 1,000 pounds available */
    public function testTranchesAmountAvailable(){
        $loan = new Loan();
        $loan->addTranche("Tranche A", 1000.00);
        $loan->addTranche("Tranche B", 1000.00);
        $amountA = $loan->getTrancheByName("Tranche A")->getAmountAvailable();
        $amountB = $loan->getTrancheByName("Tranche B")->getAmountAvailable();
        $this->assertEquals(1000.00, $amountA);
        $this->assertEquals(1000.00, $amountB);
    }

    /* - Given each investor has 1,000 pounds in his virtual wallet or account?. */
    public function testInvestorWalletHasMoney(){
        $qtOfInv = 4;
        $investors = array();
        for($i = 1; $i <= $qtOfInv; $i++){
        $investors[$i] = new Investor("Investor ".$i);
        $investors[$i]->getWallet()->addMoney(1000.00);
        }
        for($i = 1; $i <= $qtOfInv; $i++){
        $this->assertEquals(1000.00, $investors[$i]->getWallet()->getAmount());
        }
    }

    /* 
    // - As “Investor 1” I’d like to invest 1,000 pounds on the tranche “A” on 03/10/2015: “ok”.
    // - As “Investor 2” I’d like to invest 1 pound on the tranche “A” on 04/10/2015: “exception”.
    // - As “Investor 3” I’d like to invest 500 pounds on the tranche “B” on 10/10/2015: “ok”.
    // - As “Investor 4” I’d like to invest 1,100 pounds on the tranche “B” 25/10/2015: “exception”.
    */
    public function testInvestOnTranches(){
        // now I can see the need for a Command - otherwise the idea of an investor investing himself, without a command
        // may cause issues because things are tied up and the Investor is not as 'single purpose' as it should/could be
        $qtOfInv = 4;
        $investors = array();

        for($i = 1; $i <= $qtOfInv; $i++){
            $investors[$i] = new Investor("Investor ".$i);
            $investors[$i]->getWallet()->addMoney(1000.00);
        }

        $loan = new Loan();
        $loan->addTranche("Tranche A", 1000.00, 3);
        $loan->addTranche("Tranche B", 1000.00, 6);
        
        $d1 = date_create("2015-10-03");
        $today = date_format($d1, "d/m/Y");
        $this->assertEquals("ok.",$investors[1]->invest($loan, "Tranche A", 1000.00, $d1));

        $d1 = date_create("2015-10-04");
        $today = date_format($d1, "d/m/Y");
        $this->assertEquals("exception.",$investors[2]->invest($loan, "Tranche A", 1.00, $d1));

        $d1 = date_create("2015-10-10");
        $today = date_format($d1, "d/m/Y");
        $this->assertEquals("ok.",$investors[3]->invest($loan, "Tranche B", 500.00, $d1));

        $d1 = date_create("2015-10-25");
        $today = date_format($d1, "d/m/Y");
        $this->assertEquals("exception.",$investors[4]->invest($loan, "Tranche B", 1100.00, $d1));


        //extra
        $this->assertEquals("exception.",$investors[1]->invest($loan, "Tranche B", 100.00, $today));
    }

    /* 
    // - On 01/11/2015 the system runs the interest calculation for the period 01/10/2015 ->
    // 31/10/2015: 
    // - “Investor 1” earns 28.06 pounds
    // - “Investor 3” earns 21.29 pounds
    */
    public function testInterestCalculation(){

        //calculate interest ok
                //save new Interest ok
                //assign Interest to Investor - tied to investment, which is connected to an investor - only 1 way
                //add earnings to given Investor's wallet - not part of the reqs
                //should maybe be a Transaction!? yes. otherwise it is messy to tie Investor>Investment>Interest

        $qtOfInv = 4;
        $investors = array();

        for($i = 1; $i <= $qtOfInv; $i++){
            $investors[$i] = new Investor("Investor ".$i);
            $investors[$i]->getWallet()->addMoney(1000.00);
        }

        $loan = new Loan();
        $loan->addTranche("Tranche A", 1000.00, 3);
        $loan->addTranche("Tranche B", 1000.00, 6);
        
        $d1 = date_create("2015-10-03");
        $today = date_format($d1, "d/m/Y");
        $this->assertEquals("ok.",$investors[1]->invest($loan, "Tranche A", 1000.00, $d1));

        $d1 = date_create("2015-10-04");
        $today = date_format($d1, "d/m/Y");
        $this->assertEquals("exception.",$investors[2]->invest($loan, "Tranche A", 1.00, $d1));

        $d1 = date_create("2015-10-10");
        $today = date_format($d1, "d/m/Y");
        $this->assertEquals("ok.",$investors[3]->invest($loan, "Tranche B", 500.00, $d1));

        $d1 = date_create("2015-10-25");
        $today = date_format($d1, "d/m/Y");
        $this->assertEquals("exception.",$investors[4]->invest($loan, "Tranche B", 1100.00, $d1));

        /* get interval date */
        $d1 = date_create("2015-10-01");
        $t1 = date_format($d1, "d/m/Y");
        print("\n".$t1);
        
        $d2 = date_create("2015-10-31");
        $t2 = date_format($d2, "d/m/Y");
        print("\n".$t2);
        
        $interval = date_diff($d1, $d2);
        print("\n Non Inclusive Interval: ".$interval->format("%a days"));

        $interestCalculationPeriod = intval($interval->format("%a")) + 1;
        print("\n Interest Calc Interval: ".$interestCalculationPeriod);
    
        $calculator = new InterestCalculator();

        $expectedEarningsInvestor1 = 28.06;
        $expectedEarningsInvestor3 = 21.29;

        $list = $investors[1]->getAllInvestments();
        foreach($list as $invstmt){
            $actualEarningsInvestor1 = $calculator->calculateInterestPerInvestmentAndPeriod($invstmt, $d1, $d2);
        }
        $this->assertEquals($expectedEarningsInvestor1, $actualEarningsInvestor1->getAmount());
        
        //TODO extra test: verify wallet includes correct sum after interest earned
        // $investor[1]->getWallet()->addMoney($actualEarningsInvestor1);

        $list = $investors[3]->getAllInvestments();
        foreach($list as $invstmt){
            $actualEarningsInvestor3 = $calculator->calculateInterestPerInvestmentAndPeriod($invstmt, $d1, $d2);
        }
        $this->assertEquals($expectedEarningsInvestor3, $actualEarningsInvestor3->getAmount());
        

    }

}


