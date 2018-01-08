<?php

namespace Investor;

use Investor\Wallet;
use Investor\Investment;
use Investor\Tranche;
use Exception;

class Investor {

    /**
     * @var string
     */
    private $id;
    /**
     * @var string;
     */
    private $name;
    /**
     * @var Wallet
     */
    private $wallet;
    /**
     * @var array
     */
    private $investments;

    /**
     * Creates an Investor and it Wallet and associate using Investor ID
     */
    public function __construct($name = null){
        $this->name = $name;
        $this->generateId();
        $this->wallet = new Wallet($this->id);
        $this->investments = array();
    }

    public function invest($loan, $tranche, $amount, $date){
        //DONE check for amount available in tranche
        //TODO and if tranche exists
        //DONE check if amount in Wallet is <= amount to invest
        //TODO throw correct Exception for each issue below
        //DONE subract money from wallet
        //TODO maybe I need to tie the investment to an investor, as much as an investor to its investments

        if($amount <= $loan->getTrancheByName($tranche)->getAmountAvailable() && $amount <= $this->wallet->getAmount()){
            $this->getWallet()->debit($amount);
            $investment = new Investment($loan, $loan->getTrancheByName($tranche) , $amount, $date);
            $this->investments[$investment->getId()] = $investment;
            $loan->getTrancheByName($tranche)->makeInvestment($amount);
            return "ok.";
        }else{
            // throw new Exception("Cannot invest: wallet too small, tranche does not exist or amount not available in tranche");
            return "exception.";
        }

    }

    public function getAllInvestments(){
        return $this->investments;
    }

    public function generateId(){
        $this->id = bin2hex(random_bytes(10));
    }
    
    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getWallet():Wallet{
        return $this->wallet;
    }

}