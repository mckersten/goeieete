<?php

namespace PayCheckout\Api\Customer\Json\Result;

use PayCheckout\Json\Response\Result;

class Update extends Result
{      
    public function __construct(\PayCheckout\Json\Response\Response $apiResponse)
    {
        parent::__construct($apiResponse);
    }
}