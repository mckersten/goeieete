<?php

namespace PayCheckout;

class PaymentMethod
{

    public static $allHostedPaymentMethods = array ( PaymentMethod::IDEAL, PaymentMethod::PAYPAL, PaymentMethod::CREDITCARD, PaymentMethod::SEPABANKTRANSFER, PaymentMethod::KLARNAINVOICE, PaymentMethod::KLARNAACCOUNT, PaymentMethod::AFTERPAY, PaymentMethod::SOFORTBANKING );
    
    const IDEAL                     = 1;
    const PAYPAL                    = 2;
    const CREDITCARD                = 3;
    const SEPABANKTRANSFER          = 4;
    const KLARNAINVOICE             = 5;
    const KLARNAACCOUNT             = 6;
    const AFTERPAY                  = 10;
    const SOFORTBANKING             = 11;
    const ESCROWDEAL                = 12;
    const BANCONTACT                = 13;
    
    const HOSTED                    = 62;
    
    const SEPAOUTPAYMENT	        = 100;
	const SEPAINCASSO               = 101;
	const SEPABATCH                 = 102;
    const EMANDATE                  = 103;
    const SPLITOUTPAYMENTOUTPAYMENT = 104;
	const SPLITOUTPAYMENTCOLLECT    = 105;

    const SIMULATEDIDEAL	        = 128;

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
                case 'ideal'                    : return PaymentMethod::IDEAL;
                case 'paypal'                   : return PaymentMethod::PAYPAL;  		
                case 'creditcard'               : return PaymentMethod::CREDITCARD;  
                case 'sepabanktransfer'         : return PaymentMethod::SEPABANKTRANSFER;
                case 'klarnainvoice'            : return PaymentMethod::KLARNAINVOICE;
                case 'klarnaaccount'            : return PaymentMethod::KLARNAACCOUNT;
                case 'afterpay'		            : return PaymentMethod::AFTERPAY;
                case 'sofortbanking'            : return PaymentMethod::SOFORTBANKING;
                case 'escrowdeal'	            : return PaymentMethod::ESCROWDEAL;	               
                case 'hosted'		            : return PaymentMethod::HOSTED;	
                case 'sepaoutpayment'           : return PaymentMethod::SEPAOUTPAYMENT;
                case 'sepaincasso'		        : return PaymentMethod::SEPAINCASSO;
                case 'separefund'		        : return PaymentMethod::SEPABATCH;
                case 'simulatedideal'           : return PaymentMethod::SIMULATEDIDEAL;
                case 'emandate'                 : return PaymentMethod::EMANDATE;
                case 'splitoutpaymentoutpayment': return PaymentMethod::SPLITOUTPAYMENTOUTPAYMENT;
                case 'splitoutpaymentcollect'   : return PaymentMethod::SPLITOUTPAYMENTCOLLECT;
            }
        }
        return PaymentMethod::IDEAL;
    }
}