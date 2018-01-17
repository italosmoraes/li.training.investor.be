<?php

namespace Investor;

class Investor
{
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
     * @var array
     */
    private $interestEarned;

    /**
     * Investor constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->id = bin2hex(random_bytes(10));
        $this->name = $name;
        $this->wallet = new Wallet($this->id);
        $this->investments = array();
        $this->interestEarned = array();
    }

    /**
     * @param Tranche $tranche
     * @param $amount
     * @param \DateTime $date
     * @return bool
     * @throws DomainException
     */
    public function invest(Tranche $tranche, $amount, \DateTime $date):bool
    {
        if ($amount > $this->wallet->getAmount()) {
            throw new DomainException('Not enough money man');
        }

        $investment = $tranche->makeInvestment($this, $amount, $date);
        $this->investments[] = $investment;
        $this->wallet->debit($amount);

        return true;
    }

    /**
     * @param Interest $interest
     */
    public function earnInterest(Interest $interest)
    {
        $this->credit($interest->getAmount());
        $this->interestEarned[] = $interest;
    }

    /**
     * @return float
     */
    public function interestEarned():float
    {
        $total = 0;

        foreach ($this->interestEarned as $interest) {
            $total = $total + $interest->getAmount();
        }

        return $total;
    }

    /**
     * @param float $amount
     */
    public function credit(float $amount)
    {
        $this->wallet->credit($amount);
    }

    /**
     * @return float
     */
    public function getAvailableAmount():float
    {
        return $this->wallet->getAmount();
    }

    /**
     * @return array
     */
    public function getAllInvestments():array
    {
        return $this->investments;
    }

    /**
     * @return string
     */
    public function getId():string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }
}
