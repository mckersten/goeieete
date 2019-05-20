<?php

namespace PayCheckout\Api\SplitOutpayment\Json\Result;

use PayCheckout\Json\Response\Result;

class CancelCollect extends Result
{     
    public function __construct(\PayCheckout\Json\Response\Response $apiResponse)
    {
        parent::__construct($apiResponse);
    }   
}