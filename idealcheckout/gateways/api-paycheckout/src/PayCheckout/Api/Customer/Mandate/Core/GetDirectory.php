<?php

namespace PayCheckout\Api\Customer\Mandate\Core;

use PayCheckout\Api\Customer\Mandate\Base\GetDirectoryBase;
use PayCheckout\ApiAction;

class GetDirectory extends GetDirectoryBase
{
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        return parent::__construct( \PayCheckout\ApiAction::CUSTOMER_MANDATE_CORE_GETDIRECTORY );
    }
}