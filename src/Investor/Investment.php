<?php 

namespace Investor;

use Investor\Tranche;
use DateTime;

class Investment {

    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $loan;
    /**
     * @var Tranche
     */
    private $tranche;
    /**
     * @var float
     */
    private $amount;
    /**
     * @var Date
     */
    private $date;

    public function __construct($loan, $tranche, $amount, DateTime $date){
        $this->id = bin2hex(random_bytes(10));
        $this->loan = $loan;
        $this->tranche = $tranche;
        $this->amount = $amount;
        $this->date = $date;
    }

    public function getTranche() : Tranche{
        return $this->tranche;
    }

    public function getAmount(){
        return $this->amount;
    }

    public function getId(){
        return $this->id;
    }

    public function getDate() : DateTime{
        return $this->date;
    }


}