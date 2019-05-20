<?php

namespace PayCheckout\Api\Customer\Mandate\Base;

use PayCheckout\Api\Customer\Json\Internal\MandateRequest;
use PayCheckout\Api\Customer\Json\Internal\CustomerApi;
use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Api\HelpFunction;
use PayCheckout\Json\Request\Request;
use stdClass;
use Exception;

class AddBase
{
    /**
     * @var ApiMessage
     */
    protected $apiMessage;

    /**
     * @var int|string
     */
    protected $customerReference;

    public function __construct(    $apiAction, 
                                    $customerReference,
                                    $mandateId, 
                                    $sequenceType, 
                                    $mandateReason, 
                                    $returnUrl, 
                                    $biccodeBank        = null, 
                                    $notificationUrl    = null, 
                                    $langIso639         = 'nl', 
                                    $debtorReference    = null, 
                                    $purchaseId         = null, 
                                    $maxEuroAmount      = null)
    {
        $request                    = new Request();
        $this->apiMessage           = new ApiMessage($apiAction,$request);
        $this->customerReference    = $customerReference;

        // Validate supplied parameters
        $customerReference = HelpFunction::FilterStringOnFalse($customerReference);
        if ($customerReference != null && !HelpFunction::isTypeValidForReference($customerReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter customerReference[' . $customerReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($customerReference));
        }

        $mandateId = HelpFunction::FilterStringOnFalse($mandateId);
        if ($mandateId != null && !is_string($mandateId))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter mandateId[' . $mandateId . '] is supposed to be a string and not a ' . gettype($mandateId));
        }
        
        if ($sequenceType != null && !is_int($sequenceType))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter sequenceType[' . $sequenceType . '] is supposed to be an integer and not a ' . gettype($sequenceType));
        }
        else if ($sequenceType != null && 
            $sequenceType != \PayCheckout\Api\Customer\Mandate\SequenceType::ONETIME &&
            $sequenceType != \PayCheckout\Api\Customer\Mandate\SequenceType::RECURRING)
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter sequenceType[' . $sequenceType . '] is supposed to be of SequenceType::ONETIME or SequenceType::RECURRING');           
        }
        
        $mandateReason = HelpFunction::FilterStringOnFalse($mandateReason);
        if ($mandateReason != null && !is_string($mandateReason))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter mandateReason[' . $mandateReason . '] is supposed to be a string and not a ' . gettype($mandateReason));
        }
               
        $returnUrl = HelpFunction::FilterStringOnFalse($returnUrl);
        if ($returnUrl != null && !is_string($returnUrl))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter returnUrl[' . $returnUrl . '] is supposed to be a string and not a ' . gettype($returnUrl));
        }
        
        $biccodeBank = HelpFunction::FilterStringOnFalse($biccodeBank);
        if ($biccodeBank != null && !is_string($biccodeBank))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter biccodeBank[' . $biccodeBank . '] is supposed to be a string and not a ' . gettype($biccodeBank));
        }
        
        $notificationUrl = HelpFunction::FilterStringOnFalse($notificationUrl);
        if ($notificationUrl != null && !is_string($notificationUrl))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter notificationUrl[' . $notificationUrl . '] is supposed to be a string and not a ' . gettype($notificationUrl));
        }
        
        $langIso639 = HelpFunction::FilterStringOnFalse($langIso639);
        if ($langIso639 != null && !is_string($langIso639))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter langIso639[' . $langIso639 . '] is supposed to be a string and not a ' . gettype($langIso639));
        }
        
        $debtorReference = HelpFunction::FilterStringOnFalse($debtorReference);
        if ($debtorReference != null && !is_string($debtorReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter debtorReference[' . $debtorReference . '] is supposed to be a string and not a ' . gettype($debtorReference));
        }
        
        $purchaseId = HelpFunction::FilterStringOnFalse($purchaseId);
        if ($purchaseId != null && !is_string($purchaseId))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter purchaseId[' . $purchaseId . '] is supposed to be a string and not a ' . gettype($purchaseId));
        }
        
        if ($maxEuroAmount != null && !is_integer($maxEuroAmount))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter $maxEuroAmount[' . $maxEuroAmount . '] is supposed to be an integer and not a ' . gettype($maxEuroAmount));
        }
        // End validation

        // Assign values
        $mandateRequest = new MandateRequest();

        $mandateRequest->setMandateId($mandateId);
        $mandateRequest->setSequenceType($sequenceType);
        $mandateRequest->setMandateReason($mandateReason);
        $mandateRequest->setReturnURL($returnUrl);
        $mandateRequest->setBicCodeBank($biccodeBank);
        $mandateRequest->setNotificationURL($notificationUrl);
        $mandateRequest->setLangIso639($langIso639);
        $mandateRequest->setDebtorReference($debtorReference);
        $mandateRequest->setPurchaseId($purchaseId);
        $mandateRequest->setMaxEuroAmount($maxEuroAmount);

        $customerApi = new CustomerApi();
        $customerApi->setCustomerReference($customerReference);
        $customerApi->setMandateRequest($mandateRequest);

        $parameters = new stdClass;
        $parameters->CustomerApi = json_encode($customerApi);

        $request->setParameters($parameters);
    }

    /**
     * @param \PayCheckout\ApiExecutor $apiExecutor 
     * @throws Exception 
     * @return \PayCheckout\Api\Customer\Json\Result\MandateResult
     */
    public function execute($apiExecutor)
    {
        if ($apiExecutor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $apiResponse    = $apiExecutor->execute($this->apiMessage);
        $result         = new \PayCheckout\Api\Customer\Json\Result\MandateResult($apiResponse);

        $result->setCustomerReference($this->customerReference);

        if ($result->getApiResult() == \PayCheckout\ApiResult::SUCCESS &&  $result->getApiReturnValues() != null)
        {
            foreach ($result->getApiReturnValues() as $key => $value)
		    {
                if ($value !== null && strpos($key,'CustomerMandate_MandateReference') !== false)
			    {
                    if (HelpFunction::is64bit())
                    {
                        $result->setMandateReference( (int) $value);
                    }
                    else
                    {
                        $result->setMandateReference( $value);
                    }
			    }
                if ($value !== null && strpos($key,'CustomerMandate_RedirectUrl') !== false)
			    {
                    $result->setRedirectUrl($value);
			    }
            }       
        }
        return $result;       
    }
}