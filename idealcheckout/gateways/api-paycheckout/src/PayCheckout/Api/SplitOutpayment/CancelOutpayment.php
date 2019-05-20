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

class CancelOutpayment
{
    /**
     * @var ApiMessage
     */
    protected $apiMessage;

    /**
     * Summary of __construct
     * @param int|string    $paymentReference 
     * @param int|string    $splitOutpaymentOutpaymentReference
     */
    public function __construct($paymentReference, $splitOutpaymentOutpaymentReference)
    {
        $request            = new Request();
        $this->apiMessage   = new ApiMessage(\PayCheckout\ApiAction::SPLITOUTPAYMENT_CANCELOUTPAYMENT,$request);

        // Validate supplied parameters
        if ($paymentReference != null && !HelpFunction::isTypeValidForReference($paymentReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter paymentReference[' . $paymentReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($paymentReference));
        }

        if ($splitOutpaymentOutpaymentReference != null && !HelpFunction::isTypeValidForReference($splitOutpaymentOutpaymentReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter splitOutpaymentReference[' . $splitOutpaymentOutpaymentReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($splitOutpaymentOutpaymentReference));
        }

        // End validation

        // Assign values
        $customerApi = new SplitOutpaymentApi();

        $customerApi->setPaymentReference($paymentReference);
        $customerApi->setSplitOutpaymentOutpaymentReference($splitOutpaymentOutpaymentReference);

        $parameters = new stdClass;
        $parameters->SplitOutpaymentCancelOutpayment = json_encode($customerApi);

        $request->setParameters($parameters);       
    }

    /**
     * Summary of execute
     * @param \PayCheckout\ApiExecutor $executor 
     * @throws Exception 
     * @return Json\Result\CancelOutpayment
     */
    public function execute($executor)
    {
        if ($executor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $apiResponse    = $executor->execute($this->apiMessage);
        $result         = new Json\Result\CancelOutpayment($apiResponse);

        return $result;
    }
}