<?php

namespace PayCheckout\Json\Notification;

class Mandate
{
    /**
     * @var string
     */
    protected $customerReference;
    
    /**
     * @var string
     */
    protected $mandateReference;
    
    /**
     * @var string
     */
    protected $mandateId;
    
    /**
     * MandateStatus
     * @var int
     */
    protected $mandateStatus;
    
    // Getters
    
    /**
     * @return string
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }
    
    /**
     * @return string
     */
    public function getMandateReference()
    {
        return $this->mandateReference;
    }
    
    /**
     * @return string
     */
    public function getMandateId()
    {
        return $this->mandateId;
    }
    
    /**
     * @return int
     */
    public function getMandateStatus()
    {
        return $this->mandateStatus;   
    }
}