<?php

namespace PayCheckout\Api\Customer\Json\Mandate;

use PayCheckout\Json\JsonBase;
use DateTime;

class MandateSignData extends JsonBase
{
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
	protected $debtorBIC;
    
	/**
	 * @var string
	 */
	protected $debtorIBAN;
    
	/**
	 * @var string
	 */
	protected $debtorAddressLine1;
    
	/**
	 * @var string
	 */
	protected $debtorAddressLine2;
    
	/**
	 * @var double
	 */
	protected $maxAmount;
    
	/**
	 * @var string
	 */
	protected $electronicSignature;
    
	/**
	 * @var string
	 */
	protected $isoPain012Xml;
    
	/**
	 * @var string
	 */
	protected $debtorSignerName;
    
	/**
	 * @return DateTime
	 */
	function getSignatureLocalDateTime()
    {
	    return $this->signatureLocalDateTime;
    }
    
	/**
	 * @return string
	 */
	function getDebtorAccountName()
    {
	    return $this->debtorAccountName;
    }
    
	/**
	 * @return string
	 */
	function getDebtorBIC()
    {
	    return $this->debtorBIC;
    }
    
	/**
	 * @return string
	 */
	function getDebtorIBAN()
    {
	    return $this->debtorIBAN;
    }
    
	/**
	 * @return string
	 */
	function getDebtorAddressLine1()
    {
	   return $this->debtorAddressLine1;
    }
    
	/**
	 * @return string
	 */
	function getDebtorAddressLine2()
    {
        return $this->debtorAddressLine2;
    }
    
	/**
	 * @return double
	 */
	function getMaxAmount()
    {
	    return $this->maxAmount;
    }
    
	/**
	 * @return string
	 */
	function getElectronicSignature()
    {
	    return $this->electronicSignature;
    }
    
    /**
     * @return string
     */
    function getIsoPain012Xml()
    {
	    return $this->isoPain012Xml;
    }
    
	/**
	 * @return string
	 */
	function getDebtorSignerName()
    {
	    return $this->debtorSignerName;
    }
}