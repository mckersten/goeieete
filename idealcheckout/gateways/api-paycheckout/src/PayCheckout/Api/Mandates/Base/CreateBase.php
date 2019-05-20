<?php

namespace PayCheckout\Api\Mandates\Base;

use PayCheckout\Json\Mandate\MandateRequest;
use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Api\HelpFunction;
use PayCheckout\Json\Request\Request;
use stdClass;


class CreateBase
{
    public static function CreateBase(   $apiAction, 
                                         $mandateId, 
                                         $sequenceType, 
                                         $mandateReason, 
                                         $returnUrl, 
                                         $biccodeBank        = null, 
                                         $notificationUrl    = null, 
                                         $langIso639         = 'nl', 
                                         $debtorReference    = null, 
                                         $purchaseId         = null, 
                                         $maxEuroAmount      = null)
    {

        $request    = new Request();
        $apiMessage = new ApiMessage($apiAction,$request);

        // Validate supplied parameters
        $mandateId = HelpFunction::FilterStringOnFalse($mandateId);
        if ($mandateId != null && !is_string($mandateId))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter mandateId[' . $mandateId . '] is supposed to be a string and not a ' . gettype($mandateId));
        }
        
        if ($sequenceType != null && !is_int($sequenceType))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter sequenceType[' . $sequenceType . '] is supposed to be an integer and not a ' . gettype($sequenceType));
        }
        else if ($sequenceType != null && 
            $sequenceType != \PayCheckout\Api\Mandates\SequenceType::ONETIME &&
            $sequenceType != \PayCheckout\Api\Mandates\SequenceType::RECURRING)
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter sequenceType[' . $sequenceType . '] is supposed to be of SequenceType::ONETIME or SequenceType::RECURRING');           
        }
        
        $mandateReason = HelpFunction::FilterStringOnFalse($mandateReason);
        if ($mandateReason != null && !is_string($mandateReason))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter mandateReason[' . $mandateReason . '] is supposed to be a string and not a ' . gettype($mandateReason));
        }
               
        $returnUrl = HelpFunction::FilterStringOnFalse($returnUrl);
        if ($returnUrl != null && !is_string($returnUrl))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter returnUrl[' . $returnUrl . '] is supposed to be a string and not a ' . gettype($returnUrl));
        }
        
        $biccodeBank = HelpFunction::FilterStringOnFalse($biccodeBank);
        if ($biccodeBank != null && !is_string($biccodeBank))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter biccodeBank[' . $biccodeBank . '] is supposed to be a string and not a ' . gettype($biccodeBank));
        }
        
        $notificationUrl = HelpFunction::FilterStringOnFalse($notificationUrl);
        if ($notificationUrl != null && !is_string($notificationUrl))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter notificationUrl[' . $notificationUrl . '] is supposed to be a string and not a ' . gettype($notificationUrl));
        }
        
        $langIso639 = HelpFunction::FilterStringOnFalse($langIso639);
        if ($langIso639 != null && !is_string($langIso639))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter langIso639[' . $langIso639 . '] is supposed to be a string and not a ' . gettype($langIso639));
        }
        
        $debtorReference = HelpFunction::FilterStringOnFalse($debtorReference);
        if ($debtorReference != null && !is_string($debtorReference))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter debtorReference[' . $debtorReference . '] is supposed to be a string and not a ' . gettype($debtorReference));
        }
        
        $purchaseId = HelpFunction::FilterStringOnFalse($purchaseId);
        if ($purchaseId != null && !is_string($purchaseId))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter purchaseId[' . $purchaseId . '] is supposed to be a string and not a ' . gettype($purchaseId));
        }
        
        if ($maxEuroAmount != null && !is_integer($maxEuroAmount))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\CreateMandate::create parameter $maxEuroAmount[' . $maxEuroAmount . '] is supposed to be an integer and not a ' . gettype($maxEuroAmount));
        }
        // End validation

        // Assign values
        $mandateRequest = new MandateRequest();

        $mandateRequest->setMandateId($mandateId);
        $mandateRequest->setSequenceType($sequenceType);
        $mandateRequest->setMandateReason($mandateReason);
        $mandateRequest->setReturnURL($returnUrl);
        $mandateRequest->setBicCodeBank($biccodeBank);
        $mandateRequest->setNotificationURL($notificationUrl);
        $mandateRequest->setLangIso639($langIso639);
        $mandateRequest->setDebtorReference($debtorReference);
        $mandateRequest->setPurchaseId($purchaseId);
        $mandateRequest->setMaxEuroAmount($maxEuroAmount);

        $parameters = new stdClass;
        $parameters->MandateRequest = json_encode($mandateRequest);

        $request->setParameters($parameters);

        return $apiMessage;
    }
}