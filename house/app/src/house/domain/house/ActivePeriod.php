<?php
namespace App\house\domain\house;
class ActivePeriod
{
    /**
     * @var int
     */
    private $startHour;

    /**
     * @var int
     */
    private $endHour;

    /**
     * ActivePeriod constructor.
     * @param int $startHour
     * @param int $endHour
     */
    public function __construct(int $startHour, int $endHour)
    {
        $this->startHour = $startHour;
        $this->endHour = $endHour;
    }

    /**
     * @return int
     */
    public function getStartHour(): int
    {
        return $this->startHour;
    }

    /**
     * @return int
     */
    public function getEndHour(): int
    {
        return $this->endHour;
    }

}

