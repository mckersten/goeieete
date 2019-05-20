<?php

namespace PayCheckout\Json\Notification;

use PayCheckout\Json\JsonBase;
use PayCheckout\Json\Notification\PaymentStatusChange;
use PayCheckout\Json\Notification\OrderChange;
use PayCheckout\Json\Notification\Refund;
use PayCheckout\Json\Notification\RefundInformation;
use PayCheckout\Json\Notification\VerifiedBankAccount;
use PayCheckout\Json\Notification\Mandate;

class Notification extends JsonBase
{
    /**
     * @var int
     */
    protected $notificationType;
        
    /**
     * @var int|string
     */
    protected $traceReference;
    
    /**
     * @var PaymentStatusChange
     */
    protected $paymentStatusChange;
    
    /**
     * @var OrderChange
     */
    protected $orderChange;
    
    /**
     * @var RefundInformation
     */
    protected $refundInformation;
    
    /**
     * @var Mandate
     */
    protected $mandate;
    
    /**
     * @var VerifiedBankAccount
     */
    protected $verifiedBankAccount;

    /**
     * @var bool
     */
    protected $processedOffline;
   
    /**
     * @return int
     */
    public function getNotificationType()
    {
        return $this->notificationType;
    }
    
    /**
	 * @return int|string
     */
    public function getTraceReference()
    {
        return $this->traceReference;
    }
    
    /**
     * @return PaymentStatusChange
     */
    public function getPaymentStatusChange()
    {
        return $this->paymentStatusChange;
    } 
    
    /**
     * @return OrderChange
     */
    public function getOrderChange()
    {
        return $this->orderChange;
    } 
    
    /**
     * @return RefundInformation
     */
    public function getRefundInformation()
    {
        return $this->refundInformation;
    } 

    /**
     * @return bool
     */
    public function getProcessedOffline()
    {
        return $this->processedOffline;
    }
    
    /**
     * @return Mandate
     */
    public function getMandate()
    {
        return $this->mandate;
    }
    
    /**
     * @return VerifiedBankAccount
     */
    public function getVerifiedBankAccount()
    {
        return $this->verifiedBankAccount;
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
                case 'paymentStatusChange':
                    $this->paymentStatusChange = new PaymentStatusChange();
                    $this->paymentStatusChange->jsonDeserialize($value);
                    break;
                case 'orderChange':
                    $this->orderChange = new OrderChange();
                    $this->orderChange->jsonDeserialize($value);
                    break;
                case 'refundInformation':
                    $this->refundInformation = new RefundInformation();
                    $this->refundInformation->jsonDeserialize($value);
                    break;
                case 'mandate':
                    $this->mandate = new Mandate();
                    $this->mandate->jsonDeserialize($value);
                    break;
                case 'verifiedBankAccount':
                    $this->verifiedBankAccount = new VerifiedBankAccount();
                    $this->verifiedBankAccount->jsonDeserialize($value);
                    break;
            }
        }
        else
        {
            parent::setJsonData($name, $value);
        }
    }
}
