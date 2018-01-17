<?php

namespace Investor;

class Loan
{
    /**
     * @var \DateTime
     */
    private $loanStartDate;

    /**
     * @var \DateTime
     */
    private $loanEndDate;

    /**
     * @var array
     */
    private $tranches;

    /**
     * Loan constructor.
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     */
    public function __construct(\DateTime $startDate, \DateTime $endDate)
    {
        $this->loanStartDate = $startDate;
        $this->loanEndDate = $endDate;
        $this->tranches = array();
    }

    /**
     * @param $name
     * @param float $amount
     * @param float $rate
     */
    public function addTranche($name, float $amount, float $rate)
    {
        $this->tranches[$name] = new Tranche($this, $name, $amount, $rate);
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     */
    public function calculateInterest(\DateTime $start, \DateTime $end)
    {
        foreach ($this->tranches as $tranche) {
            foreach ($tranche->getInvestements() as $investement) {
                $interest = $this->calculateInterestPerInvestmentAndPeriod($investement, $start, $end);
                $investement->getInvestor()->earnInterest($interest);
            }
        }
    }

    /**
     * @param Investment $investment
     * @param \DateTime $start
     * @param \DateTime $end
     * @return Interest
     */
    private function calculateInterestPerInvestmentAndPeriod(Investment $investment, \DateTime $start, \DateTime $end)
    {
        $period = date_diff($start, $end);
        $daysInTheMonth = intval($period->format("%a")) + 1;
        $totalPotentialMonthEarnings = ($investment->getTranche()->getRate() / 100) * $investment->getAmount();
        $earningsPerDay = $totalPotentialMonthEarnings / $daysInTheMonth;
        $noOfDaysInvested = (intval(date_diff($investment->getDate(), $end)->days)) + 1; //invest day included
        $actualEarnings = $earningsPerDay * $noOfDaysInvested;

        return new Interest(round($actualEarnings, 2), $investment->getId(), $period);
    }

    /**
     * @param string $name
     * @return \Investor\Tranche
     */
    public function getTrancheByName(string $name):Tranche
    {
        return $this->tranches[$name];
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->loanStartDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->loanEndDate;
    }
}
