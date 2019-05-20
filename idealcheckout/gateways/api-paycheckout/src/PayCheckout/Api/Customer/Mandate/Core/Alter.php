<?php

namespace PayCheckout\Api\Customer\Mandate\Core;

use PayCheckout\Api\Customer\Mandate\Base\AlterBase;
use PayCheckout\ApiAction;

class Alter extends AlterBase
{
    /**
     * @param int|string $customerReference 
     * @param string $mandateReference 
     * @param string $returnUrl 
     * @param string $notificationUrl 
     */
    public function __construct(    $customerReference, 
                                    $mandateReference, 
                                    $returnUrl, 
                                    $notificationUrl    = null) 
    {
        return parent::__construct( \PayCheckout\ApiAction::CUSTOMER_MANDATE_CORE_ALTER,
                                    $customerReference,
                                    $mandateReference,
                                    $returnUrl,
                                    $notificationUrl);
    }
}