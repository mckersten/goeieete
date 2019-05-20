<?php

namespace PayCheckout\Api\Customer\Mandate\B2B;

use PayCheckout\Api\Customer\Mandate\Base\GetDirectoryBase;
use PayCheckout\ApiAction;

class GetDirectory extends GetDirectoryBase
{
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        parent::__construct( \PayCheckout\ApiAction::CUSTOMER_MANDATE_B2B_GETDIRECTORY );
    }
}