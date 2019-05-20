<?php

namespace PayCheckout\Api\SplitOutpayment\Json\Internal;

use PayCheckout\Json\JsonBase;
use DateTime;

class SplitOutpaymentApi extends JsonBase
{
    /**
     * @var int|string
     */
    protected $paymentReference;
    
    /**
     * @var int|string
     */
    protected $transactionReference;
    
    /**
     * @var int
     */
    protected $amount;
    
    /**
     * @var DateTime
     */
    protected $scheduledDate;
    
    /**
     * @var int|string
     */
    protected $customerReference;
    
    /**
     * @var int|string
     */
    protected $bankAccountReference;
    
    /**
     * @var String
     */
    protected $bundleKey;
    
    /**
     * @var String
     */
    protected $description;
    
    /**
     * @var Int|String
     */
    protected $splitOutpaymentCollectReference;
    
    /**
     * @var Int|String
     */
    protected $splitOutpaymentOutpaymentReference;
    
    /**
     * @param int|string $paymentReference 
     */
    function setPaymentReference($paymentReference)
    {
        $this->paymentReference = $paymentReference;
    }
    
    /**
     * @param int|string $transactionReference 
     */
    function setTransactionReference($transactionReference)
    {
        $this->transactionReference = $transactionReference;
    }
    
    /**
     * @param int $amount 
     */
    function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
    /**
     * @param DateTime $scheduledDate 
     */
    function setScheduledDate($scheduledDate)
    {
        $this->scheduledDate = $scheduledDate;
    }
    
    /**
     * @param int|string $customerReference 
     */
    function setCustomerReference($customerReference)
    {
        $this->customerReference = $customerReference;
    }
    
    /**
     * @param int|string $bankAccountReference 
     */
    function setBankAccountReference($bankAccountReference)
    {
        $this->bankAccountReference = $bankAccountReference;
    }
    
    /**
     * @param string $bundleKey
     */
    function setBundleKey($bundleKey)
    {
        $this->bundleKey = $bundleKey;
    }
    
    /**
     * @param string $description 
     */
    function setDescription($description)
    {
        $this->description = $description;
    }
        
    /**
     * @param int|string $splitOutpaymentCollectReference 
     */
    function setSplitOutpaymentCollectReference($splitOutpaymentCollectReference)
    {
        $this->splitOutpaymentCollectReference = $splitOutpaymentCollectReference;
    }
        
    /**
     * @param int|string $splitOutpaymentOutpaymentReference 
     */
    function setSplitOutpaymentOutpaymentReference($splitOutpaymentOutpaymentReference)
    {
        $this->splitOutpaymentOutpaymentReference = $splitOutpaymentOutpaymentReference;
    }
}