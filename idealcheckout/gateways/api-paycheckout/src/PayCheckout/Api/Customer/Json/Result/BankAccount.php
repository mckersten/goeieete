<?php

namespace PayCheckout\Api\Customer\Json\Result;

use PayCheckout\Json\Response\Result;

class BankAccount extends Result
{
    /**
     * @var int|string
     */
    protected $customerReference;
    
    /**
     * @var int|string
     */
    protected $bankAccountReference;
    
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
     * @param int|string $bankAccountReference 
     */
    public function setBankAccountReference($bankAccountReference)
    {
        $this->bankAccountReference = $bankAccountReference;
    }
    
    /**
     * @return integer|string
     */
    public function getBankAccountReference()
    {
        return $this->bankAccountReference;
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