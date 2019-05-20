<?php

namespace PayCheckout\Api\Customer\Mandate\Base;

use PayCheckout\Api\Customer\Json\Internal\MandateRequest;
use PayCheckout\Api\Customer\Json\Internal\CustomerApi;
use PayCheckout\Api\Customer\Json\Result\MandateResult;
use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Json\Request\Request;
use PayCheckout\Api\HelpFunction;
use stdClass;
use Exception;

class CancelBase
{
    /**
     * @var ApiMessage
     */
    protected $apiMessage;

    /**
     * @var int|string
     */
    protected $customerReference;

    /**
     * @var int|string
     */
    protected $mandateReference;

    public function __construct($apiAction,
                                $customerReference,
                                $mandateReference,
                                $returnUrl, 
                                $notificationUrl    = null) 
    {
        $request                    = new Request();
        $this->apiMessage           = new ApiMessage($apiAction,$request);
        $this->customerReference    = $customerReference;
        $this->mandateReference     = $mandateReference;

        // Validate supplied parameters
        $customerReference = HelpFunction::FilterStringOnFalse($customerReference);
        if ($customerReference != null && !HelpFunction::isTypeValidForReference($customerReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter customerReference[' . $customerReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($customerReference));
        }
       
        if ($mandateReference != null && !HelpFunction::isTypeValidForReference($mandateReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter mandateReference[' . $mandateReference . '] is supposed to be a 64bit interger or a string and not a ' . gettype($mandateReference));
        }

        $returnUrl = HelpFunction::FilterStringOnFalse($returnUrl);
        if ($returnUrl != null && !is_string($returnUrl))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter returnUrl[' . $returnUrl . '] is supposed to be a string and not a ' . gettype($returnUrl));
        }
               
        $notificationUrl = HelpFunction::FilterStringOnFalse($notificationUrl);
        if ($notificationUrl != null && !is_string($notificationUrl))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter notificationUrl[' . $notificationUrl . '] is supposed to be a string and not a ' . gettype($notificationUrl));
        }             
        // End validation

        // Assign values
        $mandateRequest = new MandateRequest();

        $mandateRequest->setMandateReference( (string) $mandateReference);
        $mandateRequest->setReturnURL($returnUrl);
        $mandateRequest->setNotificationURL($notificationUrl);

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
     * @return \PayCheckout\Json\Response\Result
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
                else if ($value !== null && strpos($key,'CustomerMandate_RedirectUrl') !== false)
			    {
                    $result->setRedirectUrl($value);
			    }
            }       
        }
        return $result;      
    }
}