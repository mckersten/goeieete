<?php

namespace PayCheckout\Json\Notification;

use DateTime;

class VerifiedBankAccount
{
    /**
     * @var int|string
     */
    protected $customerReference;
    
    /**
     * @var int|string
     */
    protected $bankAccountReference;
    
    /**
     * @var string
     */
    protected $nameOnBankAccount;
    
    /**
     * @var string
     */
    protected $bic;
    
    /**
     * @var string
     */
    protected $iBAN;
    
    /**
     * @var DateTime
     */
    protected $dateTimeVerified;
    
    /**
     * @return integer|string
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }
    
    /**
     * @return integer|string
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
    public function getBic()
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
     * @return DateTime
     */
    public function getDateTimeVerified()
    {
        return $this->dateTimeVerified;
    }
}