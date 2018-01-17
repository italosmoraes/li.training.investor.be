<?php

namespace Investor;

use DateTime;

class Interest
{

    /**
     * @var float
     */
    private $amount;
    /**
     * @var string
     */
    private $investmentId;
    /**
     * @var DateTime
     */
    private $period;

    public function __construct($amount, $investmentId, $period)
    {
        $this->amount = $amount;
        $this->investmentId = $investmentId;
        $this->period = $period;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}
