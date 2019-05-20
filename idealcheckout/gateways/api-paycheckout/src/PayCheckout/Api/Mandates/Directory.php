<?php

namespace PayCheckout\Api\Mandates;

use PayCheckout\Api\Mandates\DirectoryIssuers;

class Directory
{
    /**
     * @var PayCheckout\Api\Mandates\DirectoryIssuers[]
     */
    protected $countries;

    /**
     * Summary of addCountry
     * @param string $name 
     * @param mixed $issuers 
     */
    public function addCountry($name,$issuers)
    {
        $this->countries[$name] = $issuers;
    }

    /**
     * Summary of getCountries
     * @return PayCheckout\Api\Mandates\DirectoryIssuers[]
     */
    public function getCountries()
    {
        return $this->countries;
    }
}