<?php

namespace PayCheckout\Api\Customer\Json\Internal;

use PayCheckout\Json\JsonBase;
use PayCheckout\Api\Customer\Json\Internal\MandateRequest;

class CustomerApi extends JsonBase
{
    /**
     * @var int|string
     */
    protected $customerReference;
    
    /**
     * @var string
     */
    protected $reason;
    
    /**
     * @var string
     */
    protected $returnUrl;
    
    /**
     * @var string
     */
    protected $notificationUrl;

    /**
     * @var \PayCheckout\Api\Customer\Json\Internal\MandateRequest;
     */
    protected $mandateRequest;

    /**
     * @param int|string $customerReference 
     */
    function setCustomerReference($customerReference)
    {
        $this->customerReference = $customerReference;
    }
    
    /**
     * @param string $reason 
     */
    function setReason($reason)
    {
        $this->reason = $reason;
    }
    
    /**
     * @param string $returnUrl 
     */
    function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }
    
    /**
     * @param string $notificationUrl 
     */
    function setNotificationUrl($notificationUrl)
    {
        $this->notifiationUrl = $notificationUrl;
    }

    /**
     * @param \PayCheckout\Api\Customer\Json\Internal\MandateRequest $mandateRequest 
     */
    function setMandateRequest($mandateRequest)
    {
        $this->mandateRequest = $mandateRequest;
    }

    /**
     * {@inheritDoc}
     */
    protected function setJsonData($name, $value)
    {
        if (is_object($value))
        {
            switch($name)
            {
                case 'mandateRequest':
                    $this->mandateRequest = new MandateRequest();
                    $this->mandateRequest->jsonDeserialize($value);
                    break;
            }
        }
        else
        {
            parent::setJsonData($name, $value);
        }
    }
}