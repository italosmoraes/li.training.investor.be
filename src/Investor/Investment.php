<?php 

namespace Investor;

use DateTime;

class Investment
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Tranche
     */
    private $tranche;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var Investor
     */
    private $investor;

    /**
     * @param Investor $investor
     * @param \Investor\Tranche $tranche
     * @param float $amount
     * @param DateTime $date
     */
    public function __construct(Investor $investor, Tranche $tranche, float $amount, DateTime $date)
    {
        $this->id = bin2hex(random_bytes(10));
        $this->tranche = $tranche;
        $this->amount = $amount;
        $this->date = $date;
        $this->investor = $investor;
    }

    /**
     * @return \Investor\Tranche
     */
    public function getTranche() : Tranche
    {
        return $this->tranche;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    public function getDate() : DateTime
    {
        return $this->date;
    }

    /**
     * @return Investor
     */
    public function getInvestor()
    {
        return $this->investor;
    }
}
