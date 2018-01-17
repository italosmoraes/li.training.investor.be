<?php

namespace Investor;

class Tranche
{
    /**
     * @var Loan
     */
    private $loan;

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

    /**
     * @var array
     */
    private $investments;

    /**
     * Tranche constructor.
     * @param Loan $loan
     * @param string $name
     * @param float $amount
     * @param float $rate
     */
    public function __construct(Loan $loan, string $name, float $amount, float $rate)
    {
        $this->loan = $loan;
        $this->name = $name;
        $this->amountAvailable = $amount;
        $this->rate = $rate;
        $this->investments = array();
    }

    /**
     * @param Investor $investor
     * @param float $amount
     * @param \DateTime $date
     * @return Investment
     * @throws DomainException
     */
    public function makeInvestment(Investor $investor, float $amount, \DateTime $date)
    {
        if($amount > $this->getAmountAvailable()) {
            throw new DomainException('Amount not available');
        }

        $this->amountAvailable = $this->amountAvailable - $amount;

        $investment = new Investment($investor, $this, $amount, $date);
        $this->investments[] = $investment;

        return $investment;
    }

    /**
     * @return array
     */
    public function getInvestements()
    {
        return $this->investments;
    }

    /**
     * @return float
     */
    public function getAmountAvailable()
    {
        return $this->amountAvailable;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }
}
