<?php

namespace PayCheckout\Api\Customer\Mandate;

class MandateStatus
{
    const NOTSTARTED        = 0;
    const CANCELLED         = 10;
    const EXPIRED           = 20;
    const FAILURE           = 30;
    const OPEN              = 40;
    const PENDING           = 50;
    const VALID             = 60;
    const REVOKED           = 70;
}