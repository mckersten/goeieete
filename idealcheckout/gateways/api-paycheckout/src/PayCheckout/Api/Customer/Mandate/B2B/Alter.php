<?php

namespace PayCheckout\Api\Customer\Mandate\B2B;

use PayCheckout\Api\Customer\Mandate\Base\AlterBase;
use PayCheckout\ApiAction;

class Alter extends AlterBase
{
    /**
     * @param int|string $customerReference 
     * @param string $mandateReference 
     * @param string $returnUrl 
     * @param string $notificationUrl 
     * @param int    $maxEuroAmount 
     */
    public  function __construct(   $customerReference, 
                                    $mandateReference, 
                                    $returnUrl, 
                                    $notificationUrl    = null, 
                                    $maxEuroAmount      = null)
    {
        parent::__construct(        \PayCheckout\ApiAction::CUSTOMER_MANDATE_B2B_ALTER,
                                    $customerReference,
                                    $mandateReference,
                                    $returnUrl,
                                    $notificationUrl,
                                    $maxEuroAmount);
    }
}