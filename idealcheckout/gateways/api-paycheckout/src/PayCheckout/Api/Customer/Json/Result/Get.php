<?php

namespace PayCheckout\Api\Customer\Json\Result;

use PayCheckout\Json\Response\Result;

class Get extends Result
{
    /**
     * @var \PayCheckout\Api\Customer\Json\Get
     */
    protected $customer;
       
    public function __construct(\PayCheckout\Json\Response\Response $apiResponse)
    {
        parent::__construct($apiResponse);
    }
    
    /**
     * @param \PayCheckout\Api\Customer\Json\Get $customer 
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }
    
    /**
     * @return \PayCheckout\Api\Customer\Json\Get
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}