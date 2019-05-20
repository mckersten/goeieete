<?php

namespace PayCheckout\Api\BankAccount\Json;

use DateTime;
use PayCheckout\Json\JsonBase;

class BankAccount extends JsonBase
{
    /**
     * @var int|string
     */
    protected $bankAccountReference;
    
    /**
     * @var String
     */
    protected $nameOnBankAccount;
    
    /**
     * @var String
     */
    protected $bic;
    
    /**
     * @var string
     */
    protected $iBAN;
    
    /**
     * @var int|string
     */
    protected $traceReference;
    
    /**
     * @var DateTime
     */
    protected $dateTimeVerified;  
    
    /**
     * @var int
     */
    protected $verifyStatus;
    
    /**
     * @return int|string
     */
    public function getBankAccountReference()
    {
        return $this->bankAccountReference;
    }
    
    /**
     * @return string
     */
    public function getNameOnBankAccount()
    {
        return $this->nameOnBankAccount;
    }
    
    /**
     * @return string
     */
    public function getBIC()
    {
        return $this->bic;
    }
    
    /**
     * @return string
     */
    public function getIBAN()
    {
        return $this->iBAN;
    }
    
    /**
     * @return integer|string
     */
    public function getTraceReference()
    {
        return $this->traceReference;
    }
    
    /**
     * @return DateTime
     */
    public function getDateTimeVerified()
    {
        return $this->dateTimeVerified;
    }
    
    /**
     * @return int
     */
    public function getVerifyStatus()
    {
        return $this->verifyStatus;
    }
}
