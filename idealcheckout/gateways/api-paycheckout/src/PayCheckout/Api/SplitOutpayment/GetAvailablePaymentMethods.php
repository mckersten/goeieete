<?php

namespace PayCheckout\Api\SplitOutpayment;

use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\ApiExecutor;
use PayCheckout\Api\HelpFunction;
use PayCheckout\Currency;
use PayCheckout\Json\Request\Request;
use PayCheckout\Api\Service\AvailablePaymentMethod\AvailablePaymentMethod;
use PayCheckout\ApiResponse;
use PayCheckout\ApiResult;
use stdClass;
use Exception;
use DateTime;

class GetAvailablePaymentMethods
{    
    /**
     * @var \PayCheckout\ApiMessage
     */
    protected $apiMessage;

    /**
     * Get AvailablePaymentMethods for the given amount and currency
     * 
     * @param int $amount
     * @param int $currency
     * @param string $customerIpAddress
     * @param string $cultureInfo (optional when not specified cultureInfo of WebShop is used)
     * @param bool $enforceNoVAT
     * @return ApiMessage
     */
    public function __construct($amount, $currency, $customerIpAddress, $cultureInfo = null, $enforceNoVAT = null)
    {
        // Create parameters
        $parameters = new stdClass;
        $parameters->GetAvailablePaymentMethods = new stdClass;
        $parameters->GetAvailablePaymentMethods->Amount             = (string) $amount;
        $parameters->GetAvailablePaymentMethods->Currency           = (int)    $currency;
        $parameters->GetAvailablePaymentMethods->CustomerIpAddress  = (string) $customerIpAddress;
        
        if ($cultureInfo != null)
        {
            $parameters->GetAvailablePaymentMethods->CultureInfo  = (string) $cultureInfo;
        }
        if ($enforceNoVAT)
        {
            $parameters->GetAvailablePaymentMethods->EnforceNoVAT  = 'True';
        }
        
        // Create request
        $request = new Request();
        $request->setParameters($parameters);
        $request->setPaymentFlag(\PayCheckout\PaymentFlag::SPLITOUTPAYMENT);
        
        // Create ApiMessage
        $this->apiMessage = new ApiMessage(ApiAction::GET_AVAILABLE_PAYMENT_METHODS, $request);
        
        // Validation
        if ($amount != null && !HelpFunction::is32bitInt($amount))
        {
            $this->apiMessage->addValidationError('In method Api\Service\GetAvailablePaymentMethods::create parameter amount[' . $amount . '] is supposed to be a 32 bit integer and not a ' . gettype($amount));
        }
        if ($currency != null && !in_array($currency, Currency::$allCurrencies))
        {
            $this->apiMessage->addValidationError('In method Api\Service\GetAvailablePaymentMethods::create parameter currency[' . $currency . '] is supposed to be one of the predefined currencies');
        }
        $customerIpAddress = HelpFunction::FilterStringOnFalse($customerIpAddress);
        if ($customerIpAddress != null && !is_string($customerIpAddress))
        {
            $this->apiMessage->addValidationError('In method Api\Service\GetAvailablePaymentMethods::create parameter customerIpAddress[' . $customerIpAddress . '] is supposed to be a string and not a ' . gettype($customerIpAddress));
        }
        $cultureInfo = HelpFunction::FilterStringOnFalse($cultureInfo);
        if ($cultureInfo != null && !is_string($cultureInfo))
        {
            $this->apiMessage->addValidationError('In method Api\Service\GetAvailablePaymentMethods::create parameter cultureInfo[' . $cultureInfo . '] is supposed to be a string and not a ' . gettype($cultureInfo));
        }
        if ($enforceNoVAT != null && !is_bool($enforceNoVAT))
        {
            $this->apiMessage->addValidationError('In method Api\Service\GetAvailablePaymentMethods::create parameter enforceNoVAT[' . $enforceNoVAT . '] is supposed to be a bool and not a ' . gettype($enforceNoVAT));
        }
        // End validation       
    }

    /**
     * Set order billing address of order
     * 
     * @param string $countryIso3166Alpha2 
     * @param string $firstName 
     * @param string $lastName 
     * @param string $addressLine1 
     * @param string $zipCode 
     * @param string $city 
     * @param string $title 
     * @param string $addressLine2 
     * @param string $stateProvince 
     * @param DateTime|null $dateOfBirth 
     * @param string $emailAddress 
     * @param int $gender 
     * @param string $phoneNumber 
     * @param string $phoneNumber2
     * @param string $cellPhoneNumber
     * @param string $socialSecurityNumber 
     * @param string $organisation 
     * @param string $department 
     * @param string $chamberOfCommerceNumber 
     * @param string $vatNumber 
     * @throws Exception If the ApiMessage wasn't created with a PayCheckout\Api\Payment\XXX call.
     */
    public function setOrderBillingAddress(
        $countryIso3166Alpha2       = null, 
        $firstName                  = null, 
        $lastName                   = null, 
        $addressLine1               = null, 
        $zipCode                    = null, 
        $city                       = null,
        $title                      = null, 
        $addressLine2               = null, 
        $stateProvince              = null, 
        DateTime $dateOfBirth       = null, 
        $emailAddress               = null, 
        $gender                     = null,
        $phoneNumber                = null, 
        $phoneNumber2               = null, 
        $cellPhoneNumber            = null, 
        $socialSecurityNumber       = null, 
        $organisation               = null, 
        $department                 = null, 
        $chamberOfCommerceNumber    = null, 
        $vatNumber                  = null)
    {
        $this->apiMessage->payment_setOrderBillingAddress(  $countryIso3166Alpha2, 
                                                            $firstName, 
                                                            $lastName, 
                                                            $addressLine1, 
                                                            $zipCode, 
                                                            $city,
                                                            $title, 
                                                            $addressLine2, 
                                                            $stateProvince, 
                                                            $dateOfBirth, 
                                                            $emailAddress,
                                                            $gender,
                                                            $phoneNumber, 
                                                            $phoneNumber2, 
                                                            $cellPhoneNumber, 
                                                            $socialSecurityNumber, 
                                                            $organisation, 
                                                            $department, 
                                                            $chamberOfCommerceNumber, 
                                                            $vatNumber);
        
    }
  
    /**
     * Summary of execute
     * @param ApiExecutor $executor 
     * @throws Exception 
     * @return ApiResponse
     */
    public function execute($executor)
    {
        if ($executor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $result = $executor->execute($this->apiMessage);

        return $this->extractMethods($result);
    }

    /**
     * @param ApiResponse $response 
     * @return GetAvailablePaymentMethods
     */
    private function extractMethods(ApiResponse $response)
    {
        $result = new \PayCheckout\Api\SplitOutpayment\Json\Result\GetAvailablePaymentMethods($response);

        if ($response->getApiResult() != ApiResult::SUCCESS || 
            $response->getActionPerformed() != ApiAction::GET_AVAILABLE_PAYMENT_METHODS || 
            $response->getApiReturnValues() == null)
        {
            return $result;
        }
        
        $availablePaymentMethods = array();
        foreach ($response->getApiReturnValues() as $key => $value)
		{
            if ($value !== null && strpos($key,'GetAvailablePaymentMethods') !== false)
			{
				$data = json_decode($value->json, false, 512, JSON_BIGINT_AS_STRING);    
				
                if (is_array($data))
                {
                    foreach ($data as $itemValues)
                    {
                        // Check if item is an object
                        if (is_object($itemValues))
                        {
                            // Create new item and add to items
                            $item = new AvailablePaymentMethod();
                            $item->jsonDeserialize($itemValues);
							
                            $availablePaymentMethods[] = $item;
                        }
                    }
                }
			}
        }     

        $result->setAvailablePaymentMethods($availablePaymentMethods);
        return $result;
    }  
}
