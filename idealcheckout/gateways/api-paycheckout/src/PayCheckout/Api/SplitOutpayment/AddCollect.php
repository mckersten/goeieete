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

class AddCollect
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
     * @param String        $description 
     */
    public function __construct($paymentReference, $amount, $scheduledDate, $description = null)
    {
        $request            = new Request();
        $this->apiMessage   = new ApiMessage(\PayCheckout\ApiAction::SPLITOUTPAYMENT_ADDCOLLECT,$request);

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
        else if ($scheduledDate != null && !is_a($scheduledDate,"DateTime"))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter scheduledDate[' . $scheduledDate . '] is supposed to be a DateTime and not a ' . gettype($scheduledDate));
        }

        $description = HelpFunction::FilterStringOnFalse($description);
        if ($description != null && !is_string($description))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter description[' . $description . '] is supposed to be a string and not a ' . gettype($description));
        }
        // End validation

        // Assign values
        $customerApi = new SplitOutpaymentApi();

        $customerApi->setPaymentReference($paymentReference);
        $customerApi->setAmount($amount);
        $customerApi->setScheduledDate($scheduledDate);
        $customerApi->setDescription($description);

        $parameters = new stdClass;
        $parameters->SplitOutpaymentAddCollect = json_encode($customerApi);

        $request->setParameters($parameters);       
    }

    /**
     * Summary of execute
     * @param \PayCheckout\ApiExecutor $executor 
     * @throws Exception 
     * @return Json\Result\AddCollect
     */
    public function execute($executor)
    {
        if ($executor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $apiResponse    = $executor->execute($this->apiMessage);
        $result         = new Json\Result\AddCollect($apiResponse);

        if ($result->getApiResult() == \PayCheckout\ApiResult::SUCCESS &&  $result->getApiReturnValues() != null)
        {
            foreach ($result->getApiReturnValues() as $key => $value)
		    {
                if ($value !== null && strpos($key,'SplitOutpaymentAddCollectResult') !== false)
			    {
                    if (HelpFunction::is64bit())
                    {
                        $result->setSplitOutpaymentCollectReference( (int) $value);
                    }
                    else
                    {
                        $result->setSplitOutpaymentCollectReference($value);
                    }
			    }
            }       
        }
        return $result;    
    }
}