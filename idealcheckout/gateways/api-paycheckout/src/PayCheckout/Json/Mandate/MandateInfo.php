<?php

namespace PayCheckout\Json\Mandate;

use DateTime;
use PayCheckout\Json\JsonBase;
use PayCheckout\Json\Mandate\MandateIncassoInfo;
use PayCheckout\Json\Mandate\MandateHistory;

class MandateInfo extends JsonBase
{
    /**
     * @var DateTime
     */
    protected $createTimeUTC;
    
    /**
     * @var DateTime
     */
    protected $lastUpdateTimeUTC;
    
    /**
     * @var string
     */
    protected $mandateReference;
    
    /**
     * @var string
     */
    protected $mandateId;
    
    /**
     * @var boolean
     */
    protected $isCore;
    
    /**
     * @var boolean
     */
    protected $isValid;
    
    /**
     * @var PayCheckout\Json\Mandate\MandateIncassoInfo
     */
    protected $mandateIncassoInfo;
    
    /**
     * Summary of $history
     * @var PayCheckout\Json\Mandate\MandateHistory[]
     */
    protected $history;
    
    protected function addHistory($historyRecord)
    {
        $this->history[] = $historyRecord;
    }
    
    /** Get functions */
    
    /**
     * @return DateTime
     */
    public function getCreateTimeUTC()
    {
        return $this->createTimeUTC; 
    }
    
    /**
     * @return DateTime
     */
    public function getLastUpdateTimeUTC()
    {
        return $this->lastUpdateTimeUTC;
    }
    
    /**
     * @return string
     */
    public function getMandateReference()
    {
        return $this->mandateReference;
    }
    
    /**
     * @return string
     */
    public function getMandateId()
    {
        return $this->mandateId;
    }
    
    /**
     * @return boolean
     */
    public function getIsCore()
    {
        return $this->isCore;
    }
    
    /**
     * @return boolean
     */
    public function getIsValid()
    {
        return $this->isValid;
    }
    
    /**
     * @return PayCheckout\Json\Mandate\MandateIncassoInfo
     */
    public function getMandateIncassoInfo()
    {
        return $this->mandateIncassoInfo;
    }
    
    /**
     * @return PayCheckout\Json\Mandate\MandateHistory []
     */
    public function getHistory()
    {
        return $this->history;
    }
    
    /**
     * {@inheritDoc}
     */
    protected function setJsonData($name, $value)
    {        
        switch($name)
        {
            case 'createTimeUTC':
                $this->createTimeUTC = new DateTime($value);
                return;
            case 'lastUpdateTimeUTC':
                $this->lastUpdateTimeUTC = new DateTime($value);
                return;
            case 'history':
                // Transactions needs to an array (list of transactions)
                if (is_array($value))
                {
                    foreach ($value as $itemValues)
                    {
                        // Check if item is an object
                        if (is_object($itemValues))
                        {
                            // Create new item and add to items
                            $item = new MandateHistory();
                            $item->jsonDeserialize($itemValues);
							
                            $this->addHistory($item);
                        }
                    }
                }
                return;
        }	
        parent::setJsonData($name, $value);
    }
}