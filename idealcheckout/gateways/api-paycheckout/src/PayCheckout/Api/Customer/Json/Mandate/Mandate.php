<?php

namespace PayCheckout\Api\Customer\Json\Mandate;

use PayCheckout\Json\JsonBase;
use PayCheckout\Api\Customer\Json\Mandate\MandateSignData;
use PayCheckout\Api\Customer\Mandate\MandateStatus;
use PayCheckout\Api\Customer\Mandate\SequenceType;
use DateTime;

class Mandate extends JsonBase
{
    /**
     * @var int
     */
    protected $apiAction;

    /**
     * @var string
     */
    protected $mandateReference;
    
    /**
     * @var \PayCheckout\Api\Customer\Mandate\MandateStatus
     */
    protected $mandateStatus;
    
    /**
     * @var DateTime
     */
    protected $createTimeUTC;
    
    /**
     * @var DateTime
     */
    protected $lastUpdateTimeUTC;
    
    /**
     * @var bool
     */
    protected $isCore;
    
    /**
     * @var string
     */
    protected $culture;
    
    /**
     * @var string
     */
    protected $mandateId;
    
    /**
     * @var \PayCheckout\Api\Customer\Mandate\SequenceType
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
     * @var integer
     */
    protected $maxEuroAmountRequested;
    
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
    
    /**
     * @var string
     */
    protected $transactionId;	
        
    /**
     * @var string
     */
    protected $traceReference;
    
    /**
     * @var string
     */
    protected $redirectUrl;	
    
    /**
     * @var string
     */
    protected $errorCode;		
    
    /**
     * @var string
     */
    protected $errorDetail;
    
    /**
     * @var string
     */
    protected $errorMessage;
    
    /**
     * @var string
     */
    protected $errorSuggestedAction;
    
    /**
     * @var string
     */
    protected $errorDebtorMessage;
    
    /**
     * @var \PayCheckout\Api\Customer\Json\Mandate\MandateSignData
     */
    protected $mandateSignData;

    /**
     * @return int (ApiAction enum)
     */
    function getApiAction()
    {
        return $this->apiAction;
    }

    /**
     * @return string
     */
    function getMandateReference()
    {
        return $this->mandateReference;
    }
    
    /**
     * @return MandateStatus
     */
    function getMandateStatus()
    {
        return $this->mandateStatus;
    }
    
    /**
     * @return DateTime
     */
    function getCreateTimeUTC()
    {
        return $this->createTimeUTC;
    }
    
    /**
     * @return DateTime
     */
    function getLastUpdateTimeUTC()
    {
        return $this->lastUpdateTimeUTC;
    }
    
    /**
     * @return boolean
     */
    function getIsCore()
    {
        return $this->isCore;
    }
    
    /**
     * @return string
     */
    function getCulture()
    {
        return $this->culture;
    }
    
    /**
     * @return string
     */
    function getMandateId()
    {
        return $this->mandateId;
    }
    
    /**
     * @return SequenceType
     */
    function getSequenceType()
    {
        return $this->sequenceType;
    }
    
    /**
     * @return string
     */
    function getMandateReason()
    {
        return $this->mandateReason;
    }
    
    /**
     * @return string
     */
    function getBicCodeBank()
    {
        return $this->bicCodeBank;	
    }
    
    /**
     * @return string
     */
    function getLangIso639()
    {
        return $this->langIso639;
    }
    
    /**
     * @return string
     */
    function getDebtorReference()
    {
        return $this->debtorReference;
    }
     
    /**
     * @return string
     */
    function getPurchaseId()
    {
        return $this->purchaseId;
    }
    
    /**
     * @return integer
     */
    function getMaxEuroAmountRequested()
    {
        return $this->maxEuroAmountRequested;
    }
    
    /**
     * @return string
     */
    function getOriginalIBAN()
    {
        return $this->originalIBAN;
    }
     
    /**
     * @return string
     */
    function getOriginalBIC()
    {
        return $this->originalBIC;
    }
    
    /**
     * @return string
     */
    function getReturnURL()	
    {
        return $this->returnURL;
    }
    
    /**
     * @return string
     */
    function getNotificationURL()
    {
        return $this->notificationURL;
    }
    
    /**
     * @return string
     */
    function getTransactionId()	
    {
        return $this->transactionId;
    }
        
    /**
     * @return string
     */
    function getTraceReference()
    {
        return $this->traceReference;
    }
    
    /**
     * @return string
     */
    function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
    
    /**
     * @return string
     */
    function getErrorCode()	
    {
        return $this->errorCode;
    }
    
    /**
     * @return string
     */
    function getErrorDetail()
    {
        return $this->errorDetail;
    }
    
    /**
     * @return string
     */
    function getErrorMessage()
    {
        return $this->errorMessage;
    }
    
    /**
     * @return string
     */
    function getErrorSuggestedAction()
    {
        return $this->errorSuggestedAction;
    }
    
    /**
     * @return string
     */
    function getErrorDebtorMessage()
    {
        return $this->errorDebtorMessage;
    }
    
    /**
     * @return MandateSignData
     */
    function getMandateSignData()
    {
        return $this->mandateSignData;
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
                case 'mandateSignData':
                    $this->mandateSignData = new MandateSignData();
                    $this->mandateSignData->jsonDeserialize($value);
                    break;
            }
        }
        else
        {
            parent::setJsonData($name, $value);
        }
    }
}