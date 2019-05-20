<?php

namespace PayCheckout\Api\Customer\Json\Result;

use PayCheckout\Json\Response\Result;

class MandateResult extends Result
{
    /**
     * @var int|string
     */
    protected $customerReference;
    
    /**
     * @var int|string
     */
    protected $mandateReference;
    
    /**
     * @var string
     */
    protected $redirectUrl;
    
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
        
    /**
     * @param int|string $mandateReference 
     */
    public function setMandateReference($mandateReference)
    {
        $this->mandateReference = $mandateReference;
    }
    
    /**
     * @return integer|string
     */
    public function getMandateReference()
    {
        return $this->mandateReference;
    }
    
    /**
     * @param string $redirectUrl 
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }
    
    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
}