<?php
namespace App\robber\domain;

class Money
{
    /**
     * @var int
     */
    private $amount;

    /**
     * Money constructor.
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

}