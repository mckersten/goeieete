<?php

namespace PayCheckout\Json\Mandate;

use DateTime;
use PayCheckout\Json\JsonBase;
use PayCheckout\Json\Mandate\MandateIncassoInfo;
use PayCheckout\Json\Mandate\MandateRequest;
use PayCheckout\Json\Response\Response;
use PayCheckout\Json\Request\Request;
use PayCheckout\MandateStatus;

class MandateHistory extends JsonBase
{
    /**
    * @var DateTime
    */
    protected $createTimeUTC;
    
    /**
    * @var PayCheckout\ApiAction
    */
    protected $apiAction;
    
    /**
    * @var PayCheckout\MandateStatus
    */
    protected $status;
        
    /**
     * @var string
     */
    protected $remark;
    
    /**
     * @var string
     */   
	protected $transactionId;
    
    /**
     * @var string
    */
    protected $transactionReference;
    
    /**
     * @var string
     */
    protected $traceReference;
    
    /**
     * @var MandateIncassoInfo
     */
    protected $incassoInfo;
    
    /**
     * @var MandateRequest
     */
	protected $mandateRequest;
    
    /**
	 * @var Request
     */
    protected $request;
    
    /**
     * @var Response
     */
	protected $response;
    
    // Getters
    
    /**
     * @return DateTime
     */
    public function getCreateTimeUTC()
    {
        return $this->createTimeUTC;
    }
    
    /**
     * @return PayCheckout\ApiAction
     */
    public function getApiAction()
    {
        return $this->apiAction;
    }
    
    /**
     * @return PayCheckout\MandateStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }
    
    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }
    
    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->transactionReference;
    }
    
    /**
     * @return string
     */
    public function getTraceReference()
    {
        return $this->traceReference;
    }
    
    /**
     * @return PayCheckout\Json\Mandate\MandateIncassoInfo
     */
    public function getIncassoInfo()
    {
        return $this->incassoInfo;
    }
    
    /**
     * @return PayCheckout\Api\Mandates\MandateRequest
     */
    public function getMandateRequest()
    {
        return $this->mandateRequest;
    }
    
    /**
     * @return PayCheckout\Json\Request\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * @return PayCheckout\Json\Response\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * {@inheritDoc}
     */
    protected function setJsonData($name, $value)
    {        
        switch($name)
        {
            case 'createTime':
                $this->createTimeUTC = new DateTime($value);
                return;
            case 'incassoInfo':
                $this->incassoInfo = new MandateIncassoInfo();
                $this->incassoInfo->jsonDeserialize($value);
                return;
            case 'mandateRequest':
                $this->mandateRequest = new MandateRequest();
                $this->mandateRequest->jsonDeserialize($value);
                return;
            case 'request':
                $this->request = new Request();
                $this->request->jsonDeserialize($value);
                return;
            case 'response':
                $this->response = new Response();
                $this->response->jsonDeserialize($value);
                return;
        }	
        parent::setJsonData($name, $value);
    }
}