<?php

namespace PayCheckout;

class PaymentFlag
{
    public static $allPaymentFlags = array ( PaymentFlag::NOTSET, PaymentFlag::DEPOSIT, PaymentFlag::DISTRIBUTED, PaymentFlag::SPLITOUTPAYMENT);
    
    const NOTSET            = 0;
    const DEPOSIT           = 1;
    const DISTRIBUTED       = 2;
    const SPLITOUTPAYMENT   = 4;

    /**
     * Summary of Convert
     * @param string $jsonInput 
     * @return int
     */
    public static function convertFromJson($jsonInput)
    {
        if (is_string($jsonInput))
        {
            switch (strtolower($jsonInput))
            {
                case 'notset'           : return PaymentFlag::NOTSET;
                case 'deposit'          : return PaymentFlag::DEPOSIT;
                case 'distributed'      : return PaymentFlag::DISTRIBUTED;
                case 'splitoutpayment'  : return PaymentFlag::SPLITOUTPAYMENT;
            }
        }
        return PaymentMethod::NOTSET;
    }   
}