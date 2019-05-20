<?php

namespace PayCheckout\Api\Customer\Json;

use PayCheckout\Json\JsonBase;

class Insert extends JsonBase
{
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
     * setName
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * setCompanyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }
    
    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }
    
    /**
     * setChamberOfCommerce
     */
    public function setChamberOfCommerce($chamberOfCommerce)
    {
        $this->chamberOfCommerce = $chamberOfCommerce;
    }
    
    /**
     * @return string
     */
    public function getChamberOfCommerce()
    {
        return $this->chamberOfCommerce;
    }
    
    /**
     * setVatNumber
     */
    public function setVatNumber($vatNumber)
    {
        $this->vatNumber = $vatNumber;
    }
    
    /**
     * @return string
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }
    
    /**
     * setEmail
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * setAddress1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }
    
    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }
    
    /**
     * setAddress2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }
    
    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->adress2;
    }
    
    /**
     * setCity
     */
    public function setCity($city)
    {
        $this->city = $city;
    }
    
    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * setZipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }
    
    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
    
    /**
     * setIsoCountryCode
     */
    public function setIsoCountryCode($isoCountryCode)
    {
        $this->isoCountryCode = $isoCountryCode;
    }
    
    /**
     * @return string
     */
    public function getIsoCountryCode()
    {
        return $this->isoCountryCode;
    } 
}
