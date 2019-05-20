<?php

namespace PayCheckout;

class MandateStatus
{
    const SUCCESS           = 0;
    const CANCELLED         = 10;
    const EXPIRED           = 20;
    const FAILURE           = 30;
    const OPEN              = 40;
    const PENDING           = 50;
    const GetStatusFailure  = 60;
}