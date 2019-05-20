<?php

namespace PayCheckout\Api\Customer\Json\Result;

use PayCheckout\Api\Customer\Json\Result\MandateDirectory;
use PayCheckout\Json\Response\Result;

class MandateDirectoryResult extends Result
{
    /**
     * @var null|MandateDirectory
     */
    protected $issuersPerCountry;
          
    public function __construct(\PayCheckout\Json\Response\Response $apiResponse)
    {
        parent::__construct($apiResponse);
    }
    
    /**
     * @param MandateDirectory
     */
    public function setIssuersPerCountry($issuersPerCountry)
    {
        $this->issuersPerCountry = $issuersPerCountry;
    }
    
    /**
     * @return null|Directory
     */
    public function getIssuersPerCountry()
    {
        return $this->issuersPerCountry;
    }        
}