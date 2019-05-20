<?php

namespace PayCheckout\Api\Customer\Json;

use PayCheckout\Api\Customer\Json\Insert;
use PayCheckout\Api\HelpFunction;
use Exception;

class Update extends Insert
{
    /**
     * @var int|string
     */
    protected $customerReference;
    
    /**
     * setCustomerReference
     */
    public function setCustomerReference($customerReference)
    {
        if (is_int($customerReference) && HelpFunction::is64bit())
        {
            $this->customerReference = $customerReference;
        }
        else if (is_string($customerReference))
        {
            $this->customerReference = $customerReference;           
        }
        else
        {
            throw new Exception("CustomerReference must be specified as a string in 32bit environments");
        }
    }
    
    /**
     * @return int|string
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }
}
