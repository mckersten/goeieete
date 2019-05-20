<?php

namespace PayCheckout\Api\Mandates\B2B;

use PayCheckout\Json\Mandate\MandateRequest;
use PayCheckout\ApiAction;
use PayCheckout\ApiMessage;
use PayCheckout\Json\Request\Request;
use PayCheckout\Api\HelpFunction;
use stdClass;

class CancelMandate
{
    /**
     * @param string $mandateId 
     * @param string $mandateReference 
     * @param string $returnUrl 
     * @param string $notificationUrl 
     * @return \PayCheckout\ApiMessage
     */
    public static function Create(   $mandateId, 
                                     $mandateReference,
                                     $returnUrl, 
                                     $notificationUrl    = null)
    {
        $request    = new Request();
        $apiMessage = new ApiMessage(\PayCheckout\ApiAction::MANDATE_B2B_CANCELMANDATE,$request);

        // Validate supplied parameters
        $mandateId = HelpFunction::FilterStringOnFalse($mandateId);
        if ($mandateId != null && !is_string($mandateId))
        {
            $apiMessage->addValidationError('In method Api\Mandates\B2B\CancelMandate::create parameter mandateId[' . $mandateId . '] is supposed to be a string and not a ' . gettype($mandateId));
        }
        
        if ($mandateReference != null && !HelpFunction::isTypeValidForReference($mandateReference))
        {
            $apiMessage->addValidationError('In method Api\Mandates\B2B\CancelMandate::create parameter mandateReference[' . $mandateReference . '] is supposed to be a 64bit interger or a string and not a ' . gettype($mandateReference));
        }

        $returnUrl = HelpFunction::FilterStringOnFalse($returnUrl);
        if ($returnUrl != null && !is_string($returnUrl))
        {
            $apiMessage->addValidationError('In method Api\Mandates\B2B\CancelMandate::create parameter returnUrl[' . $returnUrl . '] is supposed to be a string and not a ' . gettype($returnUrl));
        }
               
        $notificationUrl = HelpFunction::FilterStringOnFalse($notificationUrl);
        if ($notificationUrl != null && !is_string($notificationUrl))
        {
            $apiMessage->addValidationError('In method Api\Mandates\B2B\CancelMandate::create parameter notificationUrl[' . $notificationUrl . '] is supposed to be a string and not a ' . gettype($notificationUrl));
        }           
        // End validation

        // Assign values
        $mandateRequest = new MandateRequest();

        $mandateRequest->setMandateId($mandateId);
        $mandateRequest->setMandateReference( (string) $mandateReference);
        $mandateRequest->setReturnURL($returnUrl);
        $mandateRequest->setNotificationURL($notificationUrl);

        $parameters = new stdClass;
        $parameters->MandateRequest = json_encode($mandateRequest);

        $request->setParameters($parameters);

        return $apiMessage;
    }
}