<?php

namespace Investor;

class Tranche {

    /**
     * @var string
     */
    private $name;
    /**
     * @var float
     */
    private $amountAvailable;
     /**
     * @var float
     */
    private $rate;

    public function __construct(string $name, float $amount = 0.0, float $rate = 0.0){
        $this->name = $name;
        $this->amountAvailable = $amount;
        $this->rate = $rate;
    }

    public function makeInvestment($amount){
        $this->amountAvailable = $this->amountAvailable - $amount;
    }

    public function getAmountAvailable(){
        return $this->amountAvailable;
    }

    public function getName(){
        return $this->name;
    }

    public function setRate($rate){
        $this->rate = $rate;
    }

    public function getRate(){
        return $this->rate;
    }
    

}