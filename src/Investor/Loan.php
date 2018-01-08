<?php

namespace Investor;

use Investor\Tranche;

class Loan {

    /**
     * @var string 
     * */
    private $loanStartDate;
    /**
     * @var string
     */
    private $loanEndDate;
    /**
     * @var array
     */
    private $tranches;
   

    public function __construct(string $startDate = "01/10/2015", string $endDate = "15/11/2015"){
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
        $this->tranches = array();
    }

    public function addTranche($name, float $amount = 0.00, float $rate = 0.0){
        $this->tranches[$name] = new Tranche($name, $amount, $rate);
    }

    public function getTrancheByName(string $name){
        return $this->tranches[$name];
    }

    public function setStartDate(string $startDate){
        $this->loanStartDate = $startDate;
    }

    public function setEndDate(string $endDate){
        $this->loanEndDate = $endDate;
    }

    public function getStartDate(){
        print "\n start date=".$this->loanStartDate;
        return $this->loanStartDate;
    }

    public function getEndDate(){
        print "\n end date=".$this->loanEndDate;
        return $this->loanEndDate;
    }

}