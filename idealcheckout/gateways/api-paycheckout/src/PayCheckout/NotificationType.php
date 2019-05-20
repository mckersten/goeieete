<?php

namespace PayCheckout;

class NotificationType
{
    const PAYMENT_STATUS_CHANGE = 0; 
    const REFUND_INFORMATION    = 10;
    const ORDER_CHANGE          = 20;
    const MANDATE_STATUS_CHANGE = 30;
    const VERIFIED_BANK_ACCOUNT = 40;
}
