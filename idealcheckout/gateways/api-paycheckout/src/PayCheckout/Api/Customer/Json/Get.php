<?php

namespace PayCheckout\Api\Customer\Json;

use PayCheckout\Api\BankAccount\Json\BankAccount;
use PayCheckout\Api\Customer\Json\Mandate\Mandate;
use PayCheckout\Json\JsonBase;

class Get extends JsonBase
{
    /**
     * @var String
     */
    protected $customerReference;
    
    /**
     * @var String
     */
    protected $name;
    
     /**
     * @var String
     */
    protected $companyName;
    
    /**
     * @var String
     */
    protected $chamberOfCommerce;
    
    /**
     * @var String
     */
    protected $vatNumber;
    
    /**
     * @var String
     */
    protected $email;
    
    /**
     * @var String
     */
    protected $address1;
    
    /**
     * @var String
     */
    protected $address2;
    
    /**
     * @var String
     */
    protected $city;
    
    /**
     * @var String
     */
    protected $zipCode;
    
    /**
     * @var String
     */
    protected $isoCountryCode;

    /**
     * @var BankAccount[]
     */
    protected $verifiedBankAccounts;
        
    /**
     * @var Mandate[]
     */
    protected $mandates;

    /**
     * @return string
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }
    
    /**
     * @return string
     */
    public function getChamberOfCommerce()
    {
        return $this->chamberOfCommerce;
    }
    
    /**
     * @return string
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }
    
    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }
    
    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
    
    /**
     * @return string
     */
    public function getIsoCountryCode()
    {
        return $this->isoCountryCode;
    }
    
    /**
     * @return bankAccount[]
     */
    public function getVerifiedBankAccounts()
    {
        return $this->verifiedBankAccounts;
    }
    
    /**
     * @return Mandate[]
     */
    public function getMandates()
    {
        return $this->mandates;
    }

    /**
     * {@inheritDoc}
     */
    protected function setJsonData($name, $value)
    {
        switch($name)
        {
            case 'verifiedBankAccounts':
                // is supposed to be an array (list of BankAccount)
                if (is_array($value))
                {
                    foreach ($value as $itemValues)
                    {
                        // Check if item is an object
                        if (is_object($itemValues))
                        {
                            // Create new bankaccount and add to VerifiedBankAccounts
                            $bankAccount = new BankAccount();
                            $bankAccount->jsonDeserialize($itemValues);
							
                            $this->verifiedBankAccounts[] = $bankAccount;
                        }
                    }
                }
                return;
            case 'mandates':
                // is supposed to be an array (list of Mandate)
                if (is_array($value))
                {
                    foreach ($value as $itemValues)
                    {
                        // Check if item is an object
                        if (is_object($itemValues))
                        {
                            // Create new mandate and add to Mandates
                            $mandate = new Mandate();
                            $mandate->jsonDeserialize($itemValues);
							
                            $this->mandates[] = $mandate;
                        }
                    }
                }
                return;
        }

        parent::setJsonData($name, $value);
    }   
}
