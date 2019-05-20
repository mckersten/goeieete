<?php

namespace PayCheckout\Api\Customer\Json\Result;

class MandateDirectoryIssuers
{
    /**
     * @var string[]
     */
    protected $issuers;
    
    public function AddIssuer($name,$bicCode)
    {
        $this->issuers[$name] = $bicCode;
    }
    
    /**
     * @return string[]
     */
    public function getIssuers()
    {
        return $this->issuers;
    }
}