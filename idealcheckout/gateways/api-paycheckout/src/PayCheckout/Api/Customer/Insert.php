<?php

namespace PayCheckout\Api\Customer;

use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Json\Request\Request;
use PayCheckout\Api\HelpFunction;
use PayCheckout\ApiExecutor;
use stdClass;
use Exception;

class Insert
{    
    /**
     * @var ApiMessage
     */
    protected $apiMessage;
    
    /**
     * @param \PayCheckout\Api\Customer\Json\Insert $customer
     */
    public function __construct($customer)
    {
        $request            = new Request();
        $this->apiMessage   = new ApiMessage(\PayCheckout\ApiAction::CUSTOMER_INSERT,$request);

        // Validate supplied parameters
        if ($customer !== null && !is_a($customer,"\PayCheckout\Api\Customer\Json\Insert"))
        {
            $this->apiMessage->addValidationError('In constructor '.get_class().' parameter customer is supposed to be an instance of \PayCheckout\Api\Customer\Json\Insert');
        }
        // End validation

        // Assign values
        $parameters = new stdClass;
        $parameters->CustomerInsert = json_encode($customer);

        $request->setParameters($parameters);       
    }

    /**
     * Summary of execute
     * @param \PayCheckout\ApiExecutor $executor 
     * @throws Exception 
     * @return Json\Result\Insert
     */
    public function execute($executor)
    {
        if ($executor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $apiResponse    = $executor->execute($this->apiMessage);
        $result         = new \PayCheckout\Api\Customer\Json\Result\Insert($apiResponse);

        if ($result->getApiResult() == \PayCheckout\ApiResult::SUCCESS &&  $result->getApiReturnValues() != null)
        {
            foreach ($result->getApiReturnValues() as $key => $value)
		    {
                if ($value !== null && strpos($key,'CustomerInsert') !== false)
			    {
                    if (HelpFunction::is64bit())
                    {
                        $result->setCustomerReference( (int) $value);
                    }
                    else
                    {
                        $result->setCustomerReference($value);
                    }
			    }
            }       
        }
        return $result;
    }
}