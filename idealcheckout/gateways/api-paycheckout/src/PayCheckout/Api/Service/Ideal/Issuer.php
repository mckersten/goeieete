<?php

namespace PayCheckout\Api\Service\Ideal;

class Issuer
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var string
     */
    private $id;
    
    /**
     * Create new issuer
     * 
     * @param string $name 
     * @param string $id 
     */
    public function __construct($name, $id)
    {
        $this->name	= $name;
        $this->id	= $id;
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
    public function getId()
    {
        return $this->id;
    }
}