<?php

namespace PayCheckout\Api\Mandates\Base;

use PayCheckout\Json\Mandate\MandateRequest;
use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Json\Request\Request;
use PayCheckout\Api\HelpFunction;
use stdClass;


class AlterBase
{
    public static function CreateBase(   $apiAction, 
                                         $mandateId, 
                                         $mandateReference,
                                         $returnUrl, 
                                         $notificationUrl    = null, 
                                         $maxEuroAmount      = null)
    {

        $request    = new Request();
        $apiMessage = new ApiMessage($apiAction,$request);

        // Validate supplied parameters
        $mandateId = HelpFunction::FilterStringOnFalse($mandateId);
        if ($mandateId != null && !is_string($mandateId))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\AlterMandate::create parameter mandateId[' . $mandateId . '] is supposed to be a string and not a ' . gettype($mandateId));
        }
        
        if ($mandateReference != null && !HelpFunction::isTypeValidForReference($mandateReference))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\AlterMandate::create parameter mandateReference[' . $mandateReference . '] is supposed to be a 64bit interger or a string and not a ' . gettype($mandateReference));
        }

        $returnUrl = HelpFunction::FilterStringOnFalse($returnUrl);
        if ($returnUrl != null && !is_string($returnUrl))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\AlterMandate::create parameter returnUrl[' . $returnUrl . '] is supposed to be a string and not a ' . gettype($returnUrl));
        }
               
        $notificationUrl = HelpFunction::FilterStringOnFalse($notificationUrl);
        if ($notificationUrl != null && !is_string($notificationUrl))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\AlterMandate::create parameter notificationUrl[' . $notificationUrl . '] is supposed to be a string and not a ' . gettype($notificationUrl));
        }      
        
        if ($maxEuroAmount != null && !is_integer($maxEuroAmount))
        {
            $apiMessage->addValidationError('In method Api\Mandates\Base\AlterMandate::create parameter $maxEuroAmount[' . $maxEuroAmount . '] is supposed to be an integer and not a ' . gettype($maxEuroAmount));
        }
        // End validation

        // Assign values
        $mandateRequest = new MandateRequest();

        $mandateRequest->setMandateId($mandateId);
        $mandateRequest->setMandateReference( (string) $mandateReference);
        $mandateRequest->setReturnURL($returnUrl);
        $mandateRequest->setNotificationURL($notificationUrl);
        $mandateRequest->setMaxEuroAmount($maxEuroAmount);

        $parameters = new stdClass;
        $parameters->MandateRequest = json_encode($mandateRequest);

        $request->setParameters($parameters);

        return $apiMessage;
    }
}