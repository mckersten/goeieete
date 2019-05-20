<?php

namespace PayCheckout\Api\Customer\Mandate\Base;

use PayCheckout\ApiAction;
use PayCheckout\ApiResult;
use PayCheckout\Api\Customer\Json\Result\MandateDirectoryIssuers;
use PayCheckout\Api\Customer\Json\Result\MandateDirectory;
use PayCheckout\ApiMessage;
use Exception;

class GetDirectoryBase
{
    /**
     * @var ApiMessage
     */
    protected $apiMessage;

    /**
     * @param int $apiAction 
     * @return \PayCheckout\ApiMessage
     */
    public function __construct($apiAction)
    {
        $this->apiMessage = new \PayCheckout\ApiMessage($apiAction);
    }

    /**
     * @param \PayCheckout\ApiExecutor $apiExecutor 
     * @throws Exception 
     * @return \PayCheckout\Api\Customer\Json\Result\MandateDirResult
     */
    public function Execute($apiExecutor)
    {
        if ($apiExecutor == null)
        {
            throw new Exception('executor passed has value null, you should construct and pass a \PayCheckout\ApiExecutor class');
        }

        $apiResponse    = $apiExecutor->execute($this->apiMessage);
        $result         = new \PayCheckout\Api\Customer\Json\Result\MandateDirectoryResult($apiResponse);

        if ($result->getApiResult() == \PayCheckout\ApiResult::SUCCESS &&  $result->getApiReturnValues() != null)
        {
            $issuersPerCountry = new MandateDirectory();
            
            foreach ($apiResponse->getApiReturnValues() as $countryName => $countryValue)
            {
                if ($countryValue !== null)
                {
                    $issuers = new MandateDirectoryIssuers();
                    
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
            $result->setIssuersPerCountry($issuersPerCountry);
        }
        return $result;       
    }
}