<?php

namespace PayCheckout\Api\Mandates\B2B;

use PayCheckout\Api\Mandates\Base\AlterBase;
use PayCheckout\ApiAction;

class AlterMandate extends AlterBase
{
    /**
     * @param string $mandateId 
     * @param string $mandateReference 
     * @param string $returnUrl 
     * @param string $notificationUrl 
     * @param int    $maxEuroAmount 
     * @return \PayCheckout\ApiMessage
     */
    public static function Create(   $mandateId, 
                                     $mandateReference, 
                                     $returnUrl, 
                                     $notificationUrl    = null, 
                                     $maxEuroAmount      = null)
    {
        return parent::CreateBase(  \PayCheckout\ApiAction::MANDATE_B2B_ALTERMANDATE,
                                    $mandateId,
                                    $mandateReference,
                                    $returnUrl,
                                    $notificationUrl,
                                    $maxEuroAmount);
    }
}