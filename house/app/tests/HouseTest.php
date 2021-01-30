<?php

use App\common\Money;
use App\house\domain\ActivePeriod;
use App\house\domain\Address;
use App\house\domain\Alarm;
use App\house\domain\House;
use App\house\domain\HouseId;
use PHPUnit\Framework\TestCase;

class HouseTest extends TestCase
{

    public function testAssault()
    {
        $house = new House(
            new HouseId(3),
            new Address('street3', '3333'),
            new Alarm('24h Alarm',
                new ActivePeriod(24, 24)
            ),
            new Money(1000)
        );

        $house->assault(1, 5);

        $this->assertEquals(500, $house->getMoney()->getAmount());

        $house->assault(1, 2);

        $this->assertEquals(400, $house->getMoney()->getAmount());
    }
}
