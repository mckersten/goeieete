<?php

namespace PayCheckout\Api\Mandates\Base;

use PayCheckout\Api\HelpFunction;
use PayCheckout\ApiMessage;
use PayCheckout\Json\Request\Request;
use PayCheckout\Json\Response\Response;
use PayCheckout\ApiResult;
use PayCheckout\Json\Mandate\MandateInfo;
use stdClass;

class GetByBase
{

    /**
     * Summary of CreateBase
     * @param mixed $mandateRequest 
     * @param int $apiAction 
     * @return ApiMessage
     */
    public static function CreateBase( $mandateRequest, $apiAction)
    {
        $request    = new Request();
        $apiMessage = new ApiMessage($apiAction,$request);

        // Validate supplied parameters
        if ($mandateRequest == null)
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\GetByBase::create parameter mandateRequest is null');            
        }
        else
        {
            $mandateId          = $mandateRequest->getMandateId();
            $mandateReference   = $mandateRequest->getMandateReference();

            // Validate supplied parameters
            $mandateId = HelpFunction::FilterStringOnFalse($mandateId);
            if ($mandateId != null && !is_string($mandateId))
            {
                $apiMessage->addValidationError('In method Api\Mandates\Base\GetByBase::create parameter mandateId[' . $mandateId . '] is supposed to be a string and not a ' . gettype($mandateId));
            }

            if ($mandateReference != null && !HelpFunction::isTypeValidForReference($mandateReference) )
            {
                $apiMessage->addValidationError('In method Api\Mandates\Base\GetByBase::create parameter mandateReference[' . $mandateReference . '] is supposed to be a 64bit interer or a string and not a ' . gettype($mandateReference));
            }
        }
        // End validation
        $parameters = new stdClass;
        $parameters->MandateRequest = json_encode($mandateRequest);

        $request->setParameters($parameters);

        return $apiMessage;       
    }

    /**
     * @param \PayCheckout\ApiResponse $apiResponse 
     * @param int $apiAction 
     */
    public static function ResponseBase ( $apiResponse, $apiAction)
    {
        if ($apiResponse->getApiResult() != ApiResult::SUCCESS || 
            $apiResponse->getActionPerformed() != $apiAction || 
            $apiResponse->getApiReturnValues() == null)
		{ 
            return null;
        }

        foreach ($apiResponse->getApiReturnValues() as $key => $value)
		{
            if ($value !== null && strpos($key,'MandateInfo') !== false)
			{
				$data = json_decode($value->json, false, 512, JSON_BIGINT_AS_STRING);    
				
				$mandateInfo = new MandateInfo();
				$mandateInfo->jsonDeserialize($data);

				return $mandateInfo;
			}
        }       
        return null;
    }
}