<?php

namespace PayCheckout\Api\Mandates\Base;

use PayCheckout\ApiAction;
use PayCheckout\ApiResult;
use PayCheckout\Json\Request\Request;
use PayCheckout\Json\Response\Response;
use PayCheckout\Api\Mandates\DirectoryIssuers;
use PayCheckout\Api\Mandates\Directory;
use PayCheckout\ApiMessage;

class DirBase
{
    /**
     * Summary of Create
     * @param int $apiAction 
     * @return \PayCheckout\ApiMessage
     */
    public static function CreateBase($apiAction)
    {
        return new \PayCheckout\ApiMessage($apiAction);
    }

    /**
     * Summary of Response
     * @param Response  $apiResponse 
     * @param int $apiAction 
     * @return null|Directory
     */
    public static function ResponseBase($apiResponse,$apiAction)
    {
        if ($apiResponse->getApiResult() != ApiResult::SUCCESS || 
            $apiResponse->getActionPerformed() != $apiAction || 
            $apiResponse->getApiReturnValues() == null)
        { 
            return null;
        }
		
        $issuersPerCountry = new Directory();
        
        foreach ($apiResponse->getApiReturnValues() as $countryName => $countryValue)
        {
            if ($countryValue !== null)
            {
                $issuers = new DirectoryIssuers();
                
                foreach ($countryValue as $issuerName => $issuerValue)
                {
                    if (isset($issuerValue->Id))
                    {
                        $issuers->AddIssuer($issuerName,$issuerValue->Id);
                    }                
                }
                
                $issuersPerCountry->addCountry($countryName,$issuers);
            }
        }        
        return $issuersPerCountry;       
    }
}