<?php

namespace PayCheckout;
    
class ApiAction
{
    const NOTSPECIFIED                          = -1;
    const PAYMENT                               = 0; 
    const STATUSREQUEST                         = 10;
    
    const NOTIFY                                = 1000;
    const MANUAL_NOTIFY                         = 1001;
    const GET_LAST_NOTIFICATION_CONTENT         = 1002;
    
    const CANCEL_ORDER                          = 2000;
    const UPDATE_ORDER                          = 2001;
    
    const REFUND                                = 3000;
    const INCLUDED_IN_SEPA_BATCH                = 3001;
    
    // Queries
	const GET_PAYMENT_INFO					    = 4000;
	const GET_TRANSACTION_INFO        		    = 4001;
    
    const GET_CURRENT_CONFIGURATION             = 4010;
    const GET_AVAILABLE_PAYMENT_METHODS         = 4020;
    const GET_MODULE_VERSION                    = 4030;
    
	// Payment Specific functions
    const KLARNA_UPDATE_P_CLASSES               = 10000;
    const KLARNA_ACCOUNT_GET_INSTALLMENTS_INFO  = 10001;
    const KLARNA_GET_ADDRESSES					= 10002;
	const KLARNA_HAS_ACCOUNT                	= 10003;
    
    const IDEAL_GET_DIRECTORY                   = 11000;

	// Customer Api
	const CUSTOMER_INSERT                       = 30000;
	const CUSTOMER_UPDATE                       = 30010;
	const CUSTOMER_GET                          = 30020;

    // Customer bankaccount
	const CUSTOMER_ADDBANKACCOUNT               = 30100;

	// Customer MandateCore
	const CUSTOMER_MANDATE_CORE_GETDIRECTORY    = 30200;
	const CUSTOMER_MANDATE_CORE_ADD             = 30210;
	const CUSTOMER_MANDATE_CORE_ALTER           = 30220;

	// Customer MandateB2B
	const CUSTOMER_MANDATE_B2B_GETDIRECTORY     = 30300;
	const CUSTOMER_MANDATE_B2B_ADD              = 30310;
	const CUSTOMER_MANDATE_B2B_ALTER            = 30320;
	const CUSTOMER_MANDATE_B2B_CANCEL           = 30330;

    // SplitOutpayment Api
	const SPLITOUTPAYMENT_ADDOUTPAYMENT 		= 40000;
	const SPLITOUTPAYMENT_CANCELOUTPAYMENT      = 40010;
	const SPLITOUTPAYMENT_ADDCOLLECT            = 40020;
	const SPLITOUTPAYMENT_CANCELCOLLECT         = 40030;
}