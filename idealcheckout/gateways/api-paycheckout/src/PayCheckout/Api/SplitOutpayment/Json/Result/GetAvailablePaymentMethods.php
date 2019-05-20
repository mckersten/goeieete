<?php

namespace PayCheckout\Api\SplitOutpayment\Json\Result;

use PayCheckout\Json\Response\Result;
use PayCheckout\Api\Service\AvailablePaymentMethod\AvailablePaymentMethod;

class GetAvailablePaymentMethods extends Result
{   
    /**
     * @var \PayCheckout\Api\Service\AvailablePaymentMethod\AvailablePaymentMethod[]
     */
    protected $availablePaymentMethods;
    
    public function __construct(\PayCheckout\Json\Response\Response $apiResponse)
    {
        parent::__construct($apiResponse);
    }  
    
    /**
     * @return \PayCheckout\Api\Service\AvailablePaymentMethod\AvailablePaymentMethod[]
     */
    public function getAvailablePaymentMethods()
    {
        return $this->availablePaymentMethods;
    }
    
    /**
     * @param \PayCheckout\Api\Service\AvailablePaymentMethod\AvailablePaymentMethod[] $availablePaymentMethods 
     */
    public function setAvailablePaymentMethods($availablePaymentMethods)
    {
        $this->availablePaymentMethods = $availablePaymentMethods;
    }
}