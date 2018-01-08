<?php

namespace Investor;

use Exception;
use DateTime;
use Investor\Interest;

class InterestCalculator {

    /**
     * Represents the Investments data retrieved from whatever persistance
     * @var array
     */
    private $investments;

    public function __construct(){
        // $this->investments = $investments;
    }

    /**
     * Receive the investment object and return the earnings
     */
    public function calculateInterestPerInvestmentAndPeriod(Investment $inv, $d1, $d2){

        //get month -> make period
        $period = date_diff($d1, $d2);
        
        //calculate return per investment - using info that should be available in the investment entity
        $daysInTheMonth = intval($period->format("%a")) + 1; //inclusive

        print("\n days in the month:".$daysInTheMonth);
        
            $totalPotentialMonthEarnings = ($inv->getTranche()->getRate()/100) * $inv->getAmount();
            print("\n total potential month earnings:".$totalPotentialMonthEarnings);
            
            $earningsPerDay = $totalPotentialMonthEarnings / $daysInTheMonth;
            print("\n per day:".$earningsPerDay);
            print("\n item date:".$inv->getDate()->format("%d/m/Y"));
            print("\n d2:".$d2->format("%d/m/Y"));
            
            $noOfDaysInvested = (intval(date_diff($inv->getDate(),$d2)->days)) + 1; //invest day included
            print("\n days invested:".$noOfDaysInvested);
            
            $actualEarnings = $earningsPerDay * $noOfDaysInvested;

            print("\n Investment amount:".$inv->getAmount()." | Interest = ".$actualEarnings);

        return new Interest(round($actualEarnings,2), $inv->getId(), $period);

    }

    public function calculateInterest($d1, $d2){

        try{

            //get month -> make period
            $period = date_diff($d1, $d2);
            print("\n d1:".$d1->format("%d/m/Y"));
            print("\n d2:".$d2->format("%d/m/Y"));
            $listOfInvestmentsToCalc = array();

            //get all investments in the period
            for($i = 0; $i < count($this->investments); $i++){
                if($this->investments[$i]->getDate() >= $d1 && $this->investments[$i]->getDate() <= $d2){
                    $listOfInvestmentsToCalc[$i] = $this->investments[$i];
                    print("\n included:".$this->investments[$i]->getId());
                }else{
                    print("\n NOT included:".$this->investments[$i]->getId());
                }
            }

            //calculate return per investment - using info that should be available in the investment entity
            $daysInTheMonth = intval($period->format("%a")) + 1; //inclusive
            print("\n days in the month:".$daysInTheMonth);
            foreach($listOfInvestmentsToCalc as $item){
                $totalPotentialMonthEarnings = ($item->getTranche()->getRate()/100) * $item->getAmount();
                print("\n total potential month earnings:".$totalPotentialMonthEarnings);
                
                $earningsPerDay = $totalPotentialMonthEarnings / $daysInTheMonth;
                print("\n per day:".$earningsPerDay);
                print("\n item date:".$item->getDate()->format("%d/m/Y"));
                print("\n d2:".$d2->format("%d/m/Y"));
                
                $noOfDaysInvested = (intval(date_diff($item->getDate(),$d2)->days)) + 1; //invest day included
                print("\n days invested:".$noOfDaysInvested);
                
                $actualEarnings = $earningsPerDay * $noOfDaysInvested;

                print("\n Investment amount:".$item->getAmount()." | Interest = ".$actualEarnings);
                
            }

            //TODO assign the interest to the correct Wallets/Investors
        
            //TODO should I add the Transaction concept? how to register the Earnings?

            return "interest calculated.";

        }catch(Exception $e){
            throw new Exception($e);
        };

    }

}