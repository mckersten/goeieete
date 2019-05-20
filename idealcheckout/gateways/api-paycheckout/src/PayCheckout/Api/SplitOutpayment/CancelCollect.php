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
use Exception;

class CancelCollect
{
    /**
     * @var ApiMessage
     */
    protected $apiMessage;

    /**
     * Summary of __construct
     * @param int|string    $paymentReference 
     * @param int|string    $splitOutpaymentCollectReference
     */
    public function __construct($paymentReference, $splitOutpaymentCollectReference)
    {
        $request            = new Request();
        $this->apiMessage   = new ApiMessage(\PayCheckout\ApiAction::SPLITOUTPAYMENT_CANCELCOLLECT,$request);

        // Validate supplied parameters
        if ($paymentReference != null && !HelpFunction::isTypeValidForReference($paymentReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter paymentReference[' . $paymentReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($paymentReference));
        }

        if ($splitOutpaymentCollectReference != null && !HelpFunction::isTypeValidForReference($splitOutpaymentCollectReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter splitOutpaymentCollectReference[' . $splitOutpaymentCollectReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($splitOutpaymentCollectReference));
        }
        // End validation

        // Assign values
        $customerApi = new SplitOutpaymentApi();

        $customerApi->setPaymentReference($paymentReference);
        $customerApi->setSplitOutpaymentCollectReference($splitOutpaymentCollectReference);

        $parameters = new stdClass;
        $parameters->SplitOutpaymentCancelCollect = json_encode($customerApi);

        $request->setParameters($parameters);       
    }

    /**
     * Summary of execute
     * @param \PayCheckout\ApiExecutor $executor 
     * @throws Exception 
     * @return Json\Result\CancelCollect
     */
    public function execute($executor)
    {
        if ($executor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $apiResponse    = $executor->execute($this->apiMessage);
        $result         = new Json\Result\CancelCollect($apiResponse);

        return $result;
    }
}