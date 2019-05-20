<?php

namespace PayCheckout\Api\SplitOutpayment\Json\Result;

use PayCheckout\Json\Response\Result;

class AddCollect extends Result
{
    /**
     * @var int|string
     */
    protected $splitOutpaymentCollectReference;
       
    public function __construct(\PayCheckout\Json\Response\Response $apiResponse)
    {
        parent::__construct($apiResponse);
    }
    
    /**
     * @param int|string $splitOutpaymentCollectReference 
     */
    public function setSplitOutpaymentCollectReference($splitOutpaymentCollectReference)
    {
        $this->splitOutpaymentCollectReference = $splitOutpaymentCollectReference;
    }
    
    /**
     * @return integer|string
     */
    public function getSplitOutpaymentCollectReference()
    {
        return $this->splitOutpaymentCollectReference;
    }
}