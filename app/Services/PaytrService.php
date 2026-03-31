<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaytrService
{
    protected string $merchantId;
    protected string $merchantKey;
    protected string $merchantSalt;

    public function __construct()
    {
        $this->merchantId = config('services.paytr.merchant_id', '');
        $this->merchantKey = config('services.paytr.merchant_key', '');
        $this->merchantSalt = config('services.paytr.merchant_salt', '');
    }

    /**
     * Generate PayTR iframe token
     */
    public function getIframeToken(array $params)
    {
        // This is a stub for the PayTR checkout logic.
        // In a real implementation, you would calculate the hash and post to PayTR API.
        
        Log::info('PayTR Payment Initiated', $params);
        
        // Mocking a token for demo
        return 'mock_paytr_token';
    }
}
