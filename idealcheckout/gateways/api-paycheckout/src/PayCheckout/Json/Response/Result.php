<?php

namespace PayCheckout\Json\Response;

use PayCheckout\Json\JsonBase;
use PayCheckout\Json\Response\Response;

class Result extends JsonBase
{
    /**
     * @var int
     */
    protected $apiResult;
    
    /**
     * @var int
     */
    protected $actionPerformed;
    
    /**
     * @var int|string
     */
    protected $traceReference;
       
    /**
     * @var int
     */
    protected $errorCode;
    
    /**
     * @var string[]
     */
    protected $errors;
    
    /**
     * @var string[]
     */
    protected $warnings;
        
    /**
     * @var mixed
     */
    protected $apiReturnValues;
    
    /**
     * Copy constructor
     * 
     * @param Response $apiResponse 
     */
    protected function __construct($apiResponse)
    {
        $this->apiResult        = $apiResponse->getApiResult();
        $this->actionPerformed  = $apiResponse->getActionPerformed();
        $this->traceReference   = $apiResponse->getTraceReference();
        $this->errorCode        = $apiResponse->getErrorCode();
        $this->errors           = $apiResponse->getErrors();
        $this->warnings         = $apiResponse->getWarnings();
        $this->apiReturnValues  = $apiResponse->getApiReturnValues();
    }
    
    /**
     * @return int
     */
    public function getApiResult()
    {
        return $this->apiResult;
    }
    
    /**
     * @param int $apiResult
     */
    public function setApiResult($apiResult)
    {
        $this->apiResult = $apiResult;
    }
    
    /**
     * @return int
     */
    public function getActionPerformed()
    {
        return $this->actionPerformed;
    }
    
    /**
     * @param int $actionPerformed 
     */
    public function setActionPerformed($actionPerformed)
    {
        $this->actionPerformed = $actionPerformed;
    }
    
    /**
	 * @return int|string
     */
    public function getTraceReference()
    {
        return $this->traceReference;
    }
    
    /**
	 * @param int|string $traceReference
     */
    public function setTraceReference($traceReference)
    {
        $this->traceReference = $traceReference;
    }
            
    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
    
    /**
     * @param int $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }
    
    /**
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * @param string[] $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }
	
	/**
     * Add an error
     * 
     * @param string $error 
     * @param array|null $args 
     */
    public function addError($error, array $args = null)
    {
        if ($args == null)
        {
            $this->errors[] = $error;
        }
        else
        {
            $this->errors[] = sprintf($error, $args);
        }
	}
    
    /**
     * @return string[]
     */
    public function getWarnings()
    {
        return $this->warnings;
    }
    
    /**
     * @param string[] $warnings
     */
    public function setWarnings(array $warnings)
    {
        $this->warnings = $warnings;
    }
	
    /**
     * Add a warning
     * 
     * @param string $warning 
     * @param array|null $args 
     */
    public function addWarning($warning, array $args = null)
    {
        if ($args == null)
        {
            $this->warnings[] = $warning;
        }
        else
        {
            $this->warnings[] = sprintf($warning, $args);
        }
    }
        
    /**
     * @return mixed
     */
    public function getApiReturnValues()
    {
        return $this->apiReturnValues;
    }
    
    /**
     * @param mixed $apiReturnValues
     */
    public function setApiReturnValues($apiReturnValues)
    {
        $this->apiReturnValues = $apiReturnValues;
    }
    
    /**
     * {@inheritDoc}
     */
    protected function setJsonData($name, $value)
    {
        if (is_object($value))
        {
            switch($name)
            {
                case 'apiReturnValues':
                    $this->setApiReturnValues($value);
                    break;
            }
        }
        else
        {
            parent::setJsonData($name, $value);
        }
    }
}