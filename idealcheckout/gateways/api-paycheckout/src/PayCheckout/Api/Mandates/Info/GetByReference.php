<?php

namespace PayCheckout\Api\Mandates\Info;

use PayCheckout\Api\Mandates\Base\GetByBase;
use PayCheckout\Json\Mandate\MandateRequest;
use PayCheckout\Json\Response\Response;

class GetByReference extends GetByBase
{
    /**
     * @param string $mandateReference 
     * @return \PayCheckout\ApiMessage
     */
    public static function Create($mandateReference)
    {
        $mandateRequest = new MandateRequest();
        $mandateRequest->setMandateReference($mandateReference);  

        return parent::CreateBase($mandateRequest, \PayCheckout\ApiAction::MANDATE_GETINFOBYREFERENCE);
    }

    /**
     * @param \PayCheckout\ApiResponse $apiResponse 
     * @return null|\PayCheckout\Json\Mandate\MandateInfo
     */
    public static function Response($apiResponse)
    {
        return parent::ResponseBase($apiResponse,\PayCheckout\ApiAction::MANDATE_GETINFOBYREFERENCE);
    }

}