<?php

namespace Investor;

use Exception;

class Wallet
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var float
     */
    private $amount;

    /**
     * Wallet constructor.
     * @param string $id
     * @param float $amount
     */
    public function __construct(string $id, float $amount = 0.00)
    {
        $this->id = $id;
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     * @throws Exception
     */
    public function credit($amount)
    {
        if ($amount > 0) {
            $this->amount = $this->amount + $amount;
        } else {
            throw new Exception("invalid credit amount");
        }
    }

    /**
     * @param $amount
     * @throws Exception
     */
    public function debit($amount)
    {
        if ($amount > 0 && $amount <= $this->amount) {
            $this->amount = $this->amount - $amount;
        } else {
            throw new Exception("invalid debit amount");
        }
    }
}
