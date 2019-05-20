<?php

namespace PayCheckout\Api\Customer\Json\Result;

use PayCheckout\Api\Customer\Json\Result\MandateDirectoryIssuers;

class MandateDirectory
{
    /**
     * @var PayCheckout\Api\Customer\Json\Result\MandateDirectoryIssuers[]
     */
    protected $countries;
    
    /**
     * Summary of addCountry
     * @param string $name 
     * @param \PayCheckout\Api\Customer\Json\Result\MandateDirectoryIssuers $issuers 
     */
    public function addCountry($name,$issuers)
    {
        $this->countries[$name] = $issuers;
    }
    
    /**
     * Summary of getCountries
     * @return PayCheckout\Api\Customer\Json\Result\MandateDirectoryIssuers[]
     */
    public function getCountries()
    {
        return $this->countries;
    }
}