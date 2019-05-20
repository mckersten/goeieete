<?php

namespace PayCheckout;
    
class VerifyStatus
{
    const NOTVERIFIED	= 0;
    const PENDING       = 10;
    const VERIFIED		= 20;
    const FAILED		= 30;
    const CANCELLED		= 40;
}