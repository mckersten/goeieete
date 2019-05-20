<?php

namespace PayCheckout\Api\Customer\Mandate\Core;

use PayCheckout\Api\Customer\Mandate\Base\AddBase;
use PayCheckout\ApiAction;

class Add extends AddBase
{
    /**
     * @param string $customerReference
     * @param string $mandateId 
     * @param string $sequenceType 
     * @param string $mandateReason 
     * @param string $returnUrl 
     * @param string $biccodeBank 
     * @param string $notificationUrl 
     * @param string $langIso639 
     * @param string $debtorReference 
     * @param string $purchaseId 
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
                                    $purchaseId         = null) 
    {
        parent::__construct(  \PayCheckout\ApiAction::CUSTOMER_MANDATE_CORE_ADD,
                                    $customerReference,
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