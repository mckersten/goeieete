<?php

namespace PayCheckout\Api\Customer\Json\Result;

use PayCheckout\Json\Response\Result;

class Insert extends Result
{
    /**
     * @var int|string
     */
    protected $customerReference;
    
    public function __construct(\PayCheckout\Json\Response\Response $apiResponse)
    { 
        parent::__construct($apiResponse);
    }
    
    /**
     * @param int|string $customerReference
     */
    public function setCustomerReference($customerReference)
    {
        $this->customerReference = $customerReference;
    }
    
    /**
     * @return integer|string
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }
}