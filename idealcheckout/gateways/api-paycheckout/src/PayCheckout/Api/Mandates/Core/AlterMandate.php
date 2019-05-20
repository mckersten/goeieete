<?php

namespace PayCheckout\Api\Mandates\Core;

use PayCheckout\Api\Mandates\Base\AlterBase;
use PayCheckout\ApiAction;

class AlterMandate extends AlterBase
{
    /**
     * @param string $mandateId 
     * @param string $mandateReference 
     * @param string $returnUrl 
     * @param string $notificationUrl 
     * @return \PayCheckout\ApiMessage
     */
    public static function Create(   $mandateId, 
                                     $mandateReference, 
                                     $returnUrl, 
                                     $notificationUrl    = null) 
    {
        return parent::CreateBase(  \PayCheckout\ApiAction::MANDATE_CORE_ALTERMANDATE,
                                    $mandateId,
                                    $mandateReference,
                                    $returnUrl,
                                    $notificationUrl);
    }
}