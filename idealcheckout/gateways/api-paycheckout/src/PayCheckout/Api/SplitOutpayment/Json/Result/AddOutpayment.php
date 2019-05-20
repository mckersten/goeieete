<?php

namespace PayCheckout\Api\SplitOutpayment\Json\Result;

use PayCheckout\Json\Response\Result;

class AddOutpayment extends Result
{
    /**
     * @var int|string
     */
    protected $splitOutpaymentOutpaymentReference;
       
    public function __construct(\PayCheckout\Json\Response\Response $apiResponse)
    {
        parent::__construct($apiResponse);
    }
    
    /**
     * @param int|string $splitOutpaymentOutpaymentReference 
     */
    public function setSplitOutpaymentOutpaymentReference($splitOutpaymentOutpaymentReference)
    {
        $this->splitOutpaymentOutpaymentReference = $splitOutpaymentOutpaymentReference;
    }
    
    /**
     * @return integer|string
     */
    public function getSplitOutpaymentOutpaymentReference()
    {
        return $this->splitOutpaymentOutpaymentReference;
    }
}