<?php

namespace PayCheckout\Api\Customer;

use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Json\Request\Request;
use PayCheckout\Api\HelpFunction;
use PayCheckout\Api\Customer\Json\Internal\CustomerApi;
use PayCheckout\ApiExecutor;
use stdClass;
use Exception;

class AddBankAccount
{
    /**
     * @var int|string
     */
    protected $customerReference;
    
    /**
     * @var ApiMessage
     */
    protected $apiMessage;
    
    /**
     * @param int|string    $customerReference 
     * @param string        $reason 
     * @param string        $returnUrl 
     * @param string        $notificationUrl 
     */
    public function __construct($customerReference, $reason, $returnUrl = null, $notificationUrl = null)
    {
        $request            = new Request();
        $this->apiMessage   = new ApiMessage(\PayCheckout\ApiAction::CUSTOMER_ADDBANKACCOUNT,$request);

        // Validate supplied parameters
        $customerReference = HelpFunction::FilterStringOnFalse($customerReference);
        if ($customerReference != null && !HelpFunction::isTypeValidForReference($customerReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter customerReference[' . $customerReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($customerReference));
        }

        $reason = HelpFunction::FilterStringOnFalse($reason);
        if ($reason != null && !is_string($reason))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter reason[' . $reason . '] is supposed to be a string and not a ' . gettype($reason));
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
        $customerApi = new CustomerApi();

        $customerApi->setCustomerReference($customerReference);
        $customerApi->setReason($reason);
        $customerApi->setReturnUrl($returnUrl);
        $customerApi->setNotificationUrl($notificationUrl);

        $parameters = new stdClass;
        $parameters->CustomerAddBankAccount = json_encode($customerApi);

        $request->setParameters($parameters);       
    }

    /**
     * Summary of execute
     * @param \PayCheckout\ApiExecutor $executor 
     * @throws Exception 
     * @return Json\Result\BankAccount
     */
    public function execute($executor)
    {
        if ($executor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $apiResponse    = $executor->execute($this->apiMessage);
        $result         = new \PayCheckout\Api\Customer\Json\Result\BankAccount($apiResponse);

        $result->setCustomerReference($this->customerReference);

        if ($result->getApiResult() == \PayCheckout\ApiResult::SUCCESS &&  $result->getApiReturnValues() != null)
        {
            foreach ($result->getApiReturnValues() as $key => $value)
		    {
                if ($value !== null && strpos($key,'CustomerAddBankAccount_BankAccountReference') !== false)
			    {
                    if (HelpFunction::is64bit())
                    {
                        $result->setBankAccountReference( (int) $value);
                    }
                    else
                    {
                        $result->setBankAccountReference( $value);
                    }
			    }
                if ($value !== null && strpos($key,'CustomerAddBankAccount_RedirectUrl') !== false)
			    {
                    $result->setRedirectUrl($value);
			    }
            }       
        }
        return $result;
    }
}