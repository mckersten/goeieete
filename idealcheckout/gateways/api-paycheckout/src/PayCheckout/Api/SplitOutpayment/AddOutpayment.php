<?php

namespace PayCheckout\Api\SplitOutpayment;

use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Json\Request\Request;
use PayCheckout\Api\HelpFunction;
use PayCheckout\ApiExecutor;
use PayCheckout\ApiResponse;
use PayCheckout\Api\SplitOutpayment\Json\Internal\SplitOutpaymentApi;
use stdClass;
use DateTime;
use Exception;

class AddOutpayment
{
    /**
     * @var ApiMessage
     */
    protected $apiMessage;

    /**
     * Summary of __construct
     * @param int|string    $paymentReference 
     * @param int           $amount 
     * @param DateTime      $scheduledDate 
     * @param int|string    $customerReference
     * @param int|string    $bankAccountReference
     * @param string        $bundleKey
     */
    public function __construct($paymentReference, $amount, $scheduledDate, $customerReference, $bankAccountReference = null, $bundleKey = null)
    {
        $request            = new Request();
        $this->apiMessage   = new ApiMessage(\PayCheckout\ApiAction::SPLITOUTPAYMENT_ADDOUTPAYMENT,$request);

        // Validate supplied parameters
        if ($paymentReference != null && !HelpFunction::isTypeValidForReference($paymentReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter paymentReference[' . $paymentReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($paymentReference));
        }

        if ($amount != null && !is_int($amount))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter amount[' . $amount . '] is supposed to be a integer and not a ' . gettype($amount));
        }

        if ($scheduledDate == null)
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter scheduledDate is supposed to contain a valid \'DateTime\' value');           
        }
        else if ($scheduledDate !== null && !is_a($scheduledDate,"DateTime"))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter scheduledDate[' . $scheduledDate . '] is supposed to be a DateTime and not a ' . gettype($scheduledDate));
        }

        if ($customerReference != null && !HelpFunction::isTypeValidForReference($customerReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter customerReference[' . $customerReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($customerReference));
        }

        if ($bankAccountReference != null && !HelpFunction::isTypeValidForReference($bankAccountReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter bankAccountReference[' . $bankAccountReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($bankAccountReference));
        }

        $bundleKey = HelpFunction::FilterStringOnFalse($bundleKey);
        if ($bundleKey != null && !is_string($bundleKey))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter bundleKey[' . $bundleKey . '] is supposed to be a string and not a ' . gettype($bundleKey));
        }
        // End validation

        // Assign values
        $customerApi = new SplitOutpaymentApi();

        $customerApi->setPaymentReference($paymentReference);
        $customerApi->setAmount($amount);
        $customerApi->setScheduledDate($scheduledDate);
        $customerApi->setCustomerReference($customerReference);
        $customerApi->setBankAccountReference($bankAccountReference);
        $customerApi->setBundleKey($bundleKey);

        $parameters = new stdClass;
        $parameters->SplitOutpaymentAddOutpayment = json_encode($customerApi);

        $request->setParameters($parameters);       
    }

    /**
     * Summary of execute
     * @param \PayCheckout\ApiExecutor $executor 
     * @throws Exception 
     * @return Json\Result\AddOutpayment
     */
    public function execute($executor)
    {
        if ($executor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $apiResponse    = $executor->execute($this->apiMessage);
        $result         = new Json\Result\AddOutpayment($apiResponse);

        if ($result->getApiResult() == \PayCheckout\ApiResult::SUCCESS &&  $result->getApiReturnValues() != null)
        {
            foreach ($result->getApiReturnValues() as $key => $value)
		    {
                if ($value !== null && strpos($key,'SplitOutpaymentAddOutpaymentResult') !== false)
			    {
                    if (HelpFunction::is64bit())
                    {
                        $result->setSplitOutpaymentOutpaymentReference( (int) $value);
                    }
                    else
                    {
                        $result->setSplitOutpaymentOutpaymentReference($value);
                    }
			    }
            }       
        }
        return $result;    
    }
}