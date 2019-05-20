<?php

namespace PayCheckout\Api\Mandates\Info;

use PayCheckout\Api\Mandates\Base\GetByBase;
use PayCheckout\Json\Mandate\MandateRequest;
use PayCheckout\Json\Response\Response;
use PayCheckout\ApiResult;

class GetById extends GetByBase
{
    /**
     * @param string $mandateId 
     * @return \PayCheckout\ApiMessage
     */
    public static function Create($mandateId)
    {
        $mandateRequest = new MandateRequest();
        $mandateRequest->setMandateId($mandateId);  

        return parent::CreateBase($mandateRequest, \PayCheckout\ApiAction::MANDATE_GETINFOBYID);
    }

    /**
     * @param \PayCheckout\ApiResponse $apiResponse 
     * @return null|\PayCheckout\Json\Mandate\MandateInfo
     */
    public static function Response($apiResponse)
    {
        return parent::ResponseBase($apiResponse,\PayCheckout\ApiAction::MANDATE_GETINFOBYID);
    }
}