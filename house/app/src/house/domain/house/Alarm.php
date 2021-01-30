<?php
namespace App\house\domain\house;
class Alarm
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ActivePeriod
     */
    private $activePeriod;

    public function __construct(string $name, ActivePeriod $activePeriod)
    {
        $this->name = $name;
        $this->activePeriod = $activePeriod;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ActivePeriod
     */
    public function getActivePeriod(): ActivePeriod
    {
        return $this->activePeriod;
    }
}

