<?php

namespace PayCheckout\Json\Mandate;

use DateTime;
use PayCheckout\Json\JsonBase;
use PayCheckout\Api\Mandates\SequenceType;

class MandateRequest extends JsonBase
{
    /**
     * @var string|int
     */
    protected $mandateReference;
    
    /**
     * @var string
     */
    protected $mandateId;
    
    /**
    /* @var PayCheckout\Api\Mandates\SequenceType
     */
    protected $sequenceType;
        
    /**
     * @var string
     */
    protected $mandateReason;		
    
    /**
     * @var string
     */
    protected $bicCodeBank;		
    
    /**
     * @var string
     */
    protected $langIso639;	
    
    /**
     * @var string
     */   
    protected $debtorReference;
    
    /**
     * @var string
     */
    protected $purchaseId;	
    
    /**
     * @var null|int
     */
    protected $maxEuroAmount;
    
    /**
     * @var string
     */
    protected $originalIBAN;	
        
    /**
     * @var string
     */
    protected $originalBIC;		
        
    /**
     * @var string
     */
    protected $returnURL;		
    
    /**
     * @var string
     */
    protected $notificationURL;
    
    /** Setters */
        
    /**
     * @param string|integer $mandateRef 
     */
    public function setMandateReference( $mandateRef)
    {
        $this->mandateReference = $mandateRef;
    }
    
	/**
	 * @param string $mandateId 
	 */
	public function setMandateId($mandateId)
    {
        $this->mandateId = $mandateId;
    }
    
	/**
	 * @param PayCheckout\Api\Mandates\SequenceyType $sequenceType 
	 */
	public function setSequenceType($sequenceType)
    {
        $this->sequenceType = $sequenceType;
    }
    
	/**
	 * @param string $mandateReason 
	 */
	public function setMandateReason($mandateReason)
    {
        $this->mandateReason = $mandateReason;
    }
    
	/**
	 * @param string $bicCodeBank 
	 */
	public function setBicCodeBank($bicCodeBank)
    {
        $this->bicCodeBank = $bicCodeBank;
    }
    
	/**
	 * @param string $langIso639 
	 */
	public function setLangIso639($langIso639)
    {
        $this->langIso639 = $langIso639;
    }
    
	/**
	 * @param string $debtorReference 
	 */
	public function setDebtorReference($debtorReference)
    {
        $this->debtorReference = $debtorReference;
    }
    
	/**
	 * @param string $purchaseId 
	 */
	public function setPurchaseId($purchaseId)
    {
        $this->purchaseId = $purchaseId;
    }
    
	/**
	 * @param null|integer $maxEuroAmount 
	 */
	public function setMaxEuroAmount($maxEuroAmount)
    {
        $this->maxEuroAmount = $maxEuroAmount;
    }
    
	/**
	 * @param string $originalIBAN 
	 */
	public function setOriginalIBAN($originalIBAN)
    {
        $this->originalIBAN = $originalIBAN;
    }
    
	/**
	 * @param string $originalBIC 
	 */
	public function setOriginalBIC($originalBIC)
    {
        $this->originalBIC = $originalBIC;
    }
    
	/**
	 * @param string $returnURL 
	 */
	public function setReturnURL($returnURL)
    {
        $this->returnURL = $returnURL;
    }
    
	/**
	 * @param string $notificationURL 
	 */
	public function setNotificationURL($notificationURL)
    {
        $this->notificationURL = $notificationURL;
    }
    
    /*  Getters */
    
    /**
     * Summary of getMandateReference
     * @return string
     */
    public function getMandateReference()
    {
        return $this->mandateReason; 
    }
        
	/**
	 * @return string
	 */
	public function getMandateId()
    {
        return $this->mandateId;
    }
    
	/**
	 * @return PayCheckout\Api\Mandates\SequenceType
	 */
	public function getSequenceType()
    {
        return $this->sequenceType;
    }
    
	/**
	 * @return string
	 */
	public function getMandateReason()
    {
        return $this->mandateReason;
    }
    
	/**
	 * @return string
	 */
	public function getBicCodeBank()
    {
        return $this->bicCodeBank;
    }
    
	/**
	 * @return string
	 */
	public function getLangIso639()
    {
        return $this->langIso639;
    }
    
	/**
	 * @return string
	 */
	public function getDebtorReference()
    {
        return $this->debtorReference;
    }
    
	/**
	 * @return string
	 */
	public function getPurchaseId()
    {
        return $this->purchaseId;
    }
    
	/**
	 * @return integer|null
	 */
	public function getMaxEuroAmount()
    {
        return $this->maxEuroAmount;
    }
        
	/**
	 * @return string
	 */
	public function getOriginalIBAN()
    {
        return $this->originalIBAN;
    }
        
	/**
	 * @return string
	 */
	public function getOriginalBIC()
    {
        return $this->originalBIC;
    }
        
	/**
	 * @return string
	 */
	public function getReturnURL()
    {
        return $this->returnURL;
    }
        
	/**
	 * @return string
	 */
	public function getNotificationURL()
    {
        return $this->notificationURL;
    }
}