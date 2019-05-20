<?php

namespace PayCheckout\Api\Customer\Mandate\B2B;

use PayCheckout\Api\Customer\Mandate\Base\AddBase;
use PayCheckout\ApiAction;

class Add extends AddBase
{
    /**
     * @param int|string    $customerReference
     * @param string        $mandateId 
     * @param int           $sequenceType 
     * @param string        $mandateReason 
     * @param string        $returnUrl 
     * @param string        $biccodeBank 
     * @param string        $notificationUrl 
     * @param string        $langIso639 
     * @param string        $debtorReference 
     * @param string        $purchaseId 
     * @param int           $maxEuroAmount 
     */
    public function __construct(    $customerReference,
                                    $mandateId, 
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
        return parent::__construct(  \PayCheckout\ApiAction::CUSTOMER_MANDATE_B2B_ADD,
                                    $customerReference,
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