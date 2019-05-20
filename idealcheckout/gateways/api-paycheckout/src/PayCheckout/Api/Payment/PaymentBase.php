<?php

namespace PayCheckout\Api\Payment;

use PayCheckout\ApiMessage;
use DateTime;

class PaymentBase
{
    /**
     * @var ApiMessage
     */
    protected $apiMessage;
    
    /**
     * Summary of setOrderInfo
     * @param string $customerOrderReference 
     * @param string $customerNote 
     */
    public function setOrderInfo($customerOrderReference = null, $customerNote = null)
    {
        $this->apiMessage->payment_setOrderInfo($customerOrderReference,$customerNote);
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
     * Set shipping address of order
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
     * @param string $phoneNumber 
     * @param string $cellPhoneNumber
     * @param string $organisation 
     * @param string $department 
     * @throws Exception If the ApiMessage wasn't created with a PayCheckout\Api\Payment\XXX call. 
     */

    public function setOrderShippingAddress(
        $countryIso3166Alpha2   = null, 
        $firstName              = null, 
        $lastName               = null, 
        $addressLine1           = null, 
        $zipCode                = null, 
        $city                   = null,
        $title                  = null, 
        $addressLine2           = null, 
        $stateProvince          = null, 
        $phoneNumber            = null, 
        $cellPhoneNumber        = null, 
        $organisation           = null, 
        $department             = null)
    {
        $this->apiMessage->payment_setOrderShippingAddress(
        $countryIso3166Alpha2, 
        $firstName, 
        $lastName, 
        $addressLine1, 
        $zipCode, 
        $city,
        $title, 
        $addressLine2, 
        $stateProvince, 
        $phoneNumber, 
        $cellPhoneNumber, 
        $organisation, 
        $department);
    }
    
    /**
     * Add item to order of payment
     * 
     * @param int $orderLineNumber
     * @param string $name 
     * @param string $description 
     * @param int $quantityOrdered
     * @param int $quantityInvoiced
     * @param int $quantityRefunded
     * @param int $quantityCancelled
     * @param int $unitPriceExclusiveVat 
     * @param int $unitPriceInclusiveVat 
     * @param int $vatDisplayPercentage
     * @param int $itemType 
     * @param int $discountDisplayPercentage 
     * @param string $skuCode 
     * @param int $unitPriceMultiplyFactorOverride
     * @throws Exception If the ApiMessage wasn't created with a PayCheckout\Api\Payment\XXX call.
     */
    public function addOrderItem(
        $orderLineNumber, 
        $name, 
        $description, 
        $quantityOrdered, 
        $quantityCancelled, 
        $quantityInvoiced, 
        $quantityRefunded, 
        $unitPriceExclusiveVat, 
        $unitPriceInclusiveVat, 
        $vatDisplayPercentage, 
        $itemType                           = ItemType::ARTICLE, 
        $discountDisplayPercentage          = null, 
        $skuCode                            = null, 
        $unitPriceMultiplyFactorOverride    = null)
    {
        $this->apiMessage->payment_addOrderItem(    $orderLineNumber, 
                                                    $name, 
                                                    $description, 
                                                    $quantityOrdered, 
                                                    $quantityCancelled, 
                                                    $quantityInvoiced, 
                                                    $quantityRefunded, 
                                                    $unitPriceExclusiveVat, 
                                                    $unitPriceInclusiveVat, 
                                                    $vatDisplayPercentage, 
                                                    $itemType, 
                                                    $discountDisplayPercentage, 
                                                    $skuCode, 
                                                    $unitPriceMultiplyFactorOverride);
    }
    
    /**
     * Set return urls override
     * 
     * @param string $returnUrlSuccess 
     * @param string $returnUrlCancelled 
     * @param string $returnUrlFailed 
     * @throws Exception 
     */
    public function overrideConfiguredReturnUrls($returnUrlSuccess = null, $returnUrlCancelled = null, $returnUrlFailed = null)
    {
        $this->apiMessage->payment_overrideConfiguredReturnUrls($returnUrlSuccess,$returnUrlCancelled,$returnUrlFailed);           
    }
    
    /**
     * @param string $notificationUrl 
     * @throws Exception 
     */
    public function overrideConfiguredNotificationUrl($notificationUrl)
    {
        $this->apiMessage->payment_overrideConfiguredNotificationUrl($notificationUrl);
    }
    
    /**
     * @param int $quantityMultiplyFactor 
     */
    public function setQuantityMultiplyFactor($quantityMultiplyFactor)
    {
        $this->apiMessage->payment_setQuantityMultiplyFactor($quantityMultiplyFactor);
    }
    
    /**
     * @param string $parameterName 
     * @param string $parameterValue 
     */
    public function addParameter($parameterName, $parameterValue)
    {
        $this->apiMessage->payment_addParameter($parameterName,$parameterValue);
    }
}