<?php

namespace PayCheckout\Api\Mandates\Core;

use PayCheckout\Api\Mandates\Base\CreateBase;
use PayCheckout\ApiAction;

class CreateMandate extends CreateBase
{
    /**
     * @param string $mandateId 
     * @param string $sequenceType 
     * @param string $mandateReason 
     * @param string $returnUrl 
     * @param string $biccodeBank 
     * @param string $notificationUrl 
     * @param string $langIso639 
     * @param string $debtorReference 
     * @param string $purchaseId 
     * @return \PayCheckout\ApiMessage
     */
    public static function Create(   $mandateId, 
                                     $sequenceType, 
                                     $mandateReason, 
                                     $returnUrl, 
                                     $biccodeBank        = null, 
                                     $notificationUrl    = null, 
                                     $langIso639         = 'nl', 
                                     $debtorReference    = null, 
                                     $purchaseId         = null) 
    {
        return parent::CreateBase(  \PayCheckout\ApiAction::MANDATE_CORE_CREATEMANDATE,
                                    $mandateId,
                                    $sequenceType,
                                    $mandateReason,
                                    $returnUrl,
                                    $biccodeBank,
                                    $notificationUrl,
                                    $langIso639,
                                    $debtorReference,
                                    $purchaseId);
    }
}