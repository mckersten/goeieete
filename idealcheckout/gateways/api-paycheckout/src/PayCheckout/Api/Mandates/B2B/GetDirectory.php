<?php

namespace PayCheckout\Api\Mandates\B2B;

use PayCheckout\Api\Mandates\Base\DirBase;
use PayCheckout\ApiAction;

class GetDirectory extends DirBase
{
    /**
     * Summary of Create
     * @return \PayCheckout\ApiMessage
     */
    public static function Create()
    {
        return parent::CreateBase( \PayCheckout\ApiAction::MANDATE_B2B_GETDIRECTORY );
    }

    /**
     * Summary of Response
     * @param \PayCheckout\ApiResponse $response 
     * @return null|\PayCheckout\Api\Mandates\Directory
     */
    public static function Response($response)
    {
        return parent::ResponseBase($response,\PayCheckout\ApiAction::MANDATE_B2B_GETDIRECTORY);
    }
}