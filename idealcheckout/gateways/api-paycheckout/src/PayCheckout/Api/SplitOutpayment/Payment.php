<?php

namespace PayCheckout\Api\SplitOutpayment;

use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Api\HelpFunction;
use PayCheckout\Json\Request\Transaction;
use PayCheckout\Json\Request\Request;
use PayCheckout\Currency;
use PayCheckout\Api\Payment\PaymentBase;
use PayCheckout\ApiExecutor;
use PayCheckout\ApiResponse;
use stdClass;
use Exception;

class Payment extends PaymentBase
{

    /**
     * Construct new payment
     * 
     * @param int    $paymentMethod 
     * @param string $merchantOrderReference 
     * @param string $description 
     * @param int    $amount 
     * @param int    $currency 
     * @param string $customerIpAddress 
     * @param string $configuredCultureOverride 
     * @param int    $expiryTimeInMinutesOverride 
     * @param array  $parameters 
     * @return ApiMessage
     */
    public function __construct($paymentMethod,$merchantOrderReference, $description, $amount, $currency,$customerIpAddress, $configuredCultureOverride = null , $expiryTimeInMinutesOverride = null, array $parameters = null)
    {
        // Create transaction
        $transaction = new Transaction\Transaction(
            $paymentMethod,
            $currency,
            $amount,
            $merchantOrderReference,
            $description,
            $customerIpAddress,
            $configuredCultureOverride,
            null
        );
        
        // Create request
        $request = new Request();
        $request->setTransaction($transaction);

        $this->apiMessage = new ApiMessage(ApiAction::PAYMENT, $request);

        $genParameters  = new stdClass;
        $dictParameters = new stdClass;
        // Add parameter expiry if applicable
        if ($expiryTimeInMinutesOverride != null && $expiryTimeInMinutesOverride > 0)
        {
            $genParameters->ExpiryTimeInMinutesOverride = (string) $expiryTimeInMinutesOverride;
        }

        // Iterate thru parameters and set if present
        if ($parameters != null)
        {
            if (!is_array($parameters))
            {
                $this->apiMessage->addValidationError('In constructor of '.get_class().' parameter parameters[' . $parameters . '] is supposed to be an associated array of key/values');
            }
            else
            {
                foreach ($parameters as $key => $value)
                {
                    if (is_string($key) && is_string($value))
                    {
                        $dictParameters->$key = $value;
                        continue;
                    }
                    if (!is_string($key))
                    {
                        $this->apiMessage->addValidationError('In constructor of '.get_class().' associative array parameter has key[' . $key . '] which is supposed to be a string and not a ' . gettype($key));
                    }
                    if (!is_string($value))
                    {
                        $this->apiMessage->addValidationError('In constructor of '.get_class().' associative array parameter has value[' . $value . '] which is supposed to be a string and not a ' . gettype($value));
                    }
                }
            }
        }

        $genParameters->GenericPayment = (object) $dictParameters;
        $request->setParameters($genParameters);

        // Mark payment as a split outpayment
        $request->setPaymentFlag(\PayCheckout\PaymentFlag::SPLITOUTPAYMENT);

        // Validate
        $merchantOrderReference = HelpFunction::FilterStringOnFalse($merchantOrderReference);
        if ($merchantOrderReference != null && !is_string($merchantOrderReference))
        {
            $this->apiMessage->addValidationError('In constructor of '.get_class().' parameter merchantOrderReference[' . $merchantOrderReference . '] is supposed to be a string and not a ' . gettype($merchantOrderReference));
        }

        $description = HelpFunction::FilterStringOnFalse($description);
        if ($description != null && !is_string($description))
        {
            $this->apiMessage->addValidationError('In constructor of '.get_class().' parameter description[' . $description . '] is supposed to be a string and not a ' . gettype($description));
        }

        if ($amount != null && !HelpFunction::is32bitInt($amount))
        {
            $this->apiMessage->addValidationError('In constructor of '.get_class().' parameter amount[' . $amount . '] is supposed to be a 32 bit integer and not a ' . gettype($amount));
        }

        if ($currency != null && !in_array($currency, Currency::$allCurrencies))
        {
            $this->apiMessage->addValidationError('In constructor of '.get_class().' parameter currency[' . $currency . '] is supposed to be one of the predefined currencies');
        }

        $customerIpAddress = HelpFunction::FilterStringOnFalse($customerIpAddress);
        if ($customerIpAddress != null && !is_string($customerIpAddress))
        {
            $this->apiMessage->addValidationError('In constructor of '.get_class().' parameter description[' . $customerIpAddress . '] is supposed to be a string and not a ' . gettype($customerIpAddress));
        }

        if ($paymentMethod != null && !HelpFunction::is32bitInt($paymentMethod))
        {
            $this->apiMessage->addValidationError('In constructor of '.get_class().' parameter paymentMethod[' . $paymentMethod . '] is supposed to be a 32 bit integer and not a ' . gettype($paymentMethod));
        }

        $configuredCultureOverride = HelpFunction::FilterStringOnFalse($configuredCultureOverride);
        if ($configuredCultureOverride != null && !is_string($configuredCultureOverride))
        {
            $this->apiMessage->addValidationError('In constructor of '.get_class().' parameter configuredCultureOverride[' . $configuredCultureOverride . '] is supposed to be a string and not a ' . gettype($configuredCultureOverride));
        }

        if ($expiryTimeInMinutesOverride != null && !HelpFunction::is32bitInt($expiryTimeInMinutesOverride))
        {
            $this->apiMessage->addValidationError('In constructor of '.get_class().' parameter expiryTimeInMinutesOverride[' . $expiryTimeInMinutesOverride . '] is supposed to be a 32 bit integer and not a ' . gettype($expiryTimeInMinutesOverride));
        }
        // End of validation   
    }

    /**
     * Summary of execute
     * @param \PayCheckout\ApiExecutor $executor 
     * @throws Exception 
     * @return \PayCheckout\ApiResponse
     */
    public function execute($executor)
    {
        if ($executor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        return $executor->execute($this->apiMessage);
    }
}