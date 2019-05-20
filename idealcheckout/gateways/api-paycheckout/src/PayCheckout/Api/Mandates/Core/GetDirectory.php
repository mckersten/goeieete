<?php

namespace PayCheckout\Api\Mandates\Core;

use PayCheckout\Api\Mandates\Base\DirBase;
use PayCheckout\ApiAction;

class GetDirectory extends DirBase
{
    /**
     * @return \PayCheckout\ApiMessage
     */
    public static function Create()
    {
        return parent::CreateBase( \PayCheckout\ApiAction::MANDATE_CORE_GETDIRECTORY );
    }

    /**
     * @param \PayCheckout\ApiResponse $response 
     * @return null|\PayCheckout\Api\Mandates\Directory
     */
    public static function Response($response)
    {
        return parent::ResponseBase($response,\PayCheckout\ApiAction::MANDATE_CORE_GETDIRECTORY);
    }
}