<?php

namespace PayCheckout\Api\Customer;

use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Api\HelpFunction;
use PayCheckout\Json\Request\Request;
use PayCheckout\Api\Customer\Json\Internal\CustomerApi;
use PayCheckout\ApiExecutor;
use stdClass;
use Exception;

class Get
{  
    /**
     * @var ApiMessage
     */
    protected $apiMessage;
    
    /**
     * @param int|string $customerReference 
     */
    public function __construct($customerReference)
    {
        $request            = new Request();
        $this->apiMessage   = new ApiMessage(\PayCheckout\ApiAction::CUSTOMER_GET,$request);

        // Validate supplied parameters
        if ($customerReference != null && !HelpFunction::isTypeValidForReference($customerReference))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter customerReference[' . $customerReference . '] is supposed to be a 64 bit integer or a string and not a ' . gettype($customerReference));
        }
        // End validation

        // Assign values
        $customerApi = new CustomerApi();

        $customerApi->setCustomerReference($customerReference);

        $parameters = new stdClass;
        $parameters->CustomerGet = json_encode($customerApi);

        $request->setParameters($parameters);       
    }

    /**
     * Summary of execute
     * @param \PayCheckout\ApiExecutor $executor 
     * @throws Exception 
     * @return Json\Result\Get
     */
    public function execute($executor)
    {
        if ($executor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $apiResponse    = $executor->execute($this->apiMessage);
        $result         = new \PayCheckout\Api\Customer\Json\Result\Get($apiResponse);

        if ($result->getApiResult() == \PayCheckout\ApiResult::SUCCESS &&  $result->getApiReturnValues() != null)
        {
            foreach ($result->getApiReturnValues() as $key => $value)
		    {
                if ($value !== null && strpos($key,'CustomerGet') !== false)
			    {
				    $data = json_decode($value->json, false, 512, JSON_BIGINT_AS_STRING);    
                    
				    $get = new \PayCheckout\Api\Customer\Json\Get();
				    $get->jsonDeserialize($data);

                    $result->setCustomer($get);
			    }
            }       
        }
        return $result;
    }
}