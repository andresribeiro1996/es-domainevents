<?php

namespace App\house\domain\house;
class Address
{
    /**
     * @var string
     */
    private $streetName;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * Address constructor.
     * @param string $streetName
     * @param string $postalCode
     */
    public function __construct(string $streetName, string $postalCode)
    {
        $this->streetName = $streetName;
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getStreetName(): string
    {
        return $this->streetName;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }




}

