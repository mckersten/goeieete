<?php

namespace PayCheckout\Api\Customer\Mandate\B2B;

use PayCheckout\Api\Customer\Mandate\Base\CancelBase;
use PayCheckout\ApiAction;

class Cancel extends CancelBase
{
    /**
     * @param string $customerReference 
     * @param string $mandateReference 
     * @param string $returnUrl 
     * @param string $notificationUrl 
     */
    public function __construct(   $customerReference, 
                                   $mandateReference,
                                   $returnUrl, 
                                   $notificationUrl    = null)
    {
        parent::__construct(        \PayCheckout\ApiAction::CUSTOMER_MANDATE_B2B_CANCEL,
                                    $customerReference,
                                    $mandateReference,
                                    $returnUrl,
                                    $notificationUrl);
    }
}