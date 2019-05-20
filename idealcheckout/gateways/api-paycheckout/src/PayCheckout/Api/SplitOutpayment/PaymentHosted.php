<?php

namespace PayCheckout\Api\SplitOutpayment;

use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Api\HelpFunction;
use PayCheckout\Json\Request\Transaction;
use PayCheckout\Json\Request\Request;
use PayCheckout\PaymentMethod;
use PayCheckout\Currency;
use PayCheckout\Api\Payment\PaymentBase;
use stdClass;
use Exception;

class PaymentHosted extends PaymentBase
{
    /**
	 * Create new hosted payment
	 * 
	 * @param string $merchantOrderReference
	 * @param string $description
	 * @param int    $amount
	 * @param int    $currency
     * @param array  $paymentMethods
     * @param int    $expiryTimeInMinutesOverride
     * @param string $configuredCultureOverride
     * @param int    $expiryTimeInMinutesOverride
     * @param bool   $enforceNoVAT
     * @return ApiMessage
	 */
    public function __construct($merchantOrderReference, $description, $amount, $currency, array $paymentMethods = null, $configuredCultureOverride = null , $expiryTimeInMinutesOverride = null, $enforceNoVAT = null)
    {
        // Create transaction
        $transaction = new Transaction\Transaction(
            PaymentMethod::HOSTED,
            $currency,
            $amount,
            $merchantOrderReference,
            $description,
            null,
            $configuredCultureOverride,
            $paymentMethods,
            $enforceNoVAT
        );
        
        // Create request
        $request = new Request();
        $request->setTransaction($transaction);

        // Mark payment as a split outpayment
        $request->setPaymentFlag(\PayCheckout\PaymentFlag::SPLITOUTPAYMENT);
        
        // Add parameter expiry if applicable
        if ($expiryTimeInMinutesOverride != null && $expiryTimeInMinutesOverride > 0)
        {
            $parameters = new stdClass;
            $parameters->ExpiryTimeInMinutesOverride = (string) $expiryTimeInMinutesOverride;
            $request->setParameters($parameters);
        }
        
        $this->apiMessage = new ApiMessage(ApiAction::PAYMENT, $request);

        // Validate
        $merchantOrderReference = HelpFunction::FilterStringOnFalse($merchantOrderReference);
        if ($merchantOrderReference != null && !is_string($merchantOrderReference))
        {
            $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter merchantOrderReference[' . $merchantOrderReference . '] is supposed to be a string and not a ' . gettype($merchantOrderReference));
        }
        $description = HelpFunction::FilterStringOnFalse($description);
        if ($description != null && !is_string($description))
        {
            $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter description[' . $description . '] is supposed to be a string and not a ' . gettype($description));
        }
        if ($amount != null && !HelpFunction::is32bitInt($amount))
        {
            $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter amount[' . $amount . '] is supposed to be a 32 bit integer and not a ' . gettype($amount));
        }
        if ($currency != null && !in_array($currency, Currency::$allCurrencies))
        {
            $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter currency[' . $currency . '] is supposed to be one of the predefined currencies');
        }
        if ($paymentMethods != null)
        {
            if (!is_array($paymentMethods))
            {
                $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter paymentMethods[' . $paymentMethods . '] is supposed to be an array of payment methods');
            }
            else
            {
                foreach ($paymentMethods as $paymentMethod )
                {
                    if (!HelpFunction::is32bitInt($paymentMethod))
                    {
                        $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter paymentMethods array element paymentMethod[' . $paymentMethod . '] is supposed to be a 32 bit integer and not a ' . gettype($paymentMethod));
                    }
                    else if (!in_array( $paymentMethod, PaymentMethod::$allHostedPaymentMethods))
                    {
                        $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter paymentMethods array element paymentMethod[' . $paymentMethod . '] is not in the list of valid hosted paymentMethods');
                    }
                }
                unset($paymentMethod);
            }
        }
        $configuredCultureOverride = HelpFunction::FilterStringOnFalse($configuredCultureOverride);
        if ($configuredCultureOverride != null && !is_string($configuredCultureOverride))
        {
            $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter configuredCultureOverride[' . $configuredCultureOverride . '] is supposed to be a string and not a ' . gettype($configuredCultureOverride));
        }
        if ($expiryTimeInMinutesOverride != null && !HelpFunction::is32bitInt($expiryTimeInMinutesOverride))
        {
            $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter expiryTimeInMinutesOverride[' . $expiryTimeInMinutesOverride . '] is supposed to be a 32 bit integer and not a ' . gettype($expiryTimeInMinutesOverride));
        }
        if ($enforceNoVAT != null && !is_bool($enforceNoVAT))
        {
            $this->apiMessage->addValidationError('In method Api\Payment\Hosted::create parameter enforceNoVAT[' . $enforceNoVAT . '] is supposed to be a bool and not a ' .gettype($enforceNoVAT));
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