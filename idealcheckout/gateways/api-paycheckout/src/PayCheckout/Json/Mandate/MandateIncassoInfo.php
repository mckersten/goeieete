<?php

namespace PayCheckout\Json\Mandate;

use DateTime;
use PayCheckout\Json\JsonBase;

class MandateIncassoInfo extends JsonBase
{
    /**
     * @var string
     */
    protected $mandateId;
    
    /**
     * @var DateTime
     */
    protected $signatureLocalDateTime;
        
    /**
     * @var string
     */
    protected $debtorAccountName;
        
    /**
     * @var string
     */
    protected $debtorAddressLine1;
        
    /**
     * @var string
     */
    protected $debtorAddressLine2;
        
    /**
     * @var string
     */
    protected $debtorBIC;
        
    /**
     * @var string
     */
    protected $debtorIBAN;
    
    /**
     * @var null | number
     */
    protected $maxAmount;
    
    /**
     * @var string
     */
    protected $electronicSignature;
        
    /**
     * @var string
     */
    protected $signerName;
        
    /**
     * @var string
     */
    protected $isoPain012Xml;
    
    // Getters
    
    public function getMandateId()
    {
        return $this->mandateId;        
    }
        
    /**
     * @return DateTime
     */
    public function getSignatureLocalDateTime()
    {
        return $this->signatureLocalDateTime;       
    }
    
    /**
     * @return string
     */
    public function getDebtorAccountName()
    {
        return $this->debtorAccountName;
    }
    
    /**
     * @return string
     */
    public function getDebtorAddressLine1()
    {
        return $this->debtorAddressLine1;
    }
    
    /**
     * @return string
     */
    public function getDebtorAddressLine2()
    {
        return $this->debtorAddressLine2;
    }
    
    /**
     * @return string
     */
    public function getDebtorBIC()
    {
        return $this->debtorBIC;
    }
        
    /**
     * @return string
     */
    public function getDebtorIBAN()
    {
        return $this->debtorIBAN;
    }
    
    /**
     * @return null|integer
     */
    public function getMaxAmount()
    {
        return $this->maxAmount;
    }
        
    /**
     * @return string
     */
    public function getElectronicSignature()
    {
        return $this->electronicSignature;
    }
    
    /**
     * @return string
     */
    public function getSignerName()
    {
        return $this->signerName;
    }
    
    /**
     * @return string
     */
    public function getIsoPain012Xml()
    {
        return $this->isoPain012Xml;
    }
    
    /**
     * {@inheritDoc}
     */
    protected function setJsonData($name, $value)
    {        
        switch($name)
        {
            case 'signatureLocalDateTime':
                $this->signatureLocalDateTime = new DateTime($value);
                return;
        }	
        parent::setJsonData($name, $value);
    }
}