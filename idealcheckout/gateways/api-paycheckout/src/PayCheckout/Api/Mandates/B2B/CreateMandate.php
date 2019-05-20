<?php

namespace PayCheckout\Api\Mandates\B2B;

use PayCheckout\Api\Mandates\Base\CreateBase;
use PayCheckout\ApiAction;

class CreateMandate extends CreateBase
{
    /**
     * @param string $mandateId 
     * @param int    $sequenceType 
     * @param string $mandateReason 
     * @param string $returnUrl 
     * @param string $biccodeBank 
     * @param string $notificationUrl 
     * @param string $langIso639 
     * @param string $debtorReference 
     * @param string $purchaseId 
     * @param int    $maxEuroAmount 
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
                                     $purchaseId         = null, 
                                     $maxEuroAmount      = null)
    {
        return parent::CreateBase(  \PayCheckout\ApiAction::MANDATE_B2B_CREATEMANDATE,
                                    $mandateId,
                                    $sequenceType,
                                    $mandateReason,
                                    $returnUrl,
                                    $biccodeBank,
                                    $notificationUrl,
                                    $langIso639,
                                    $debtorReference,
                                    $purchaseId,
                                    $maxEuroAmount);
    }
}