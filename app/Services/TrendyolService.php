<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TrendyolService
{
    protected string $sellerId;
    protected string $apiKey;
    protected string $apiSecret;
    protected string $integrationCode;
    protected string $baseUrl = 'https://api.trendyol.com/sapigw/suppliers';

    public function __construct()
    {
        $this->sellerId = config('services.trendyol.seller_id');
        $this->apiKey = config('services.trendyol.api_key');
        $this->apiSecret = config('services.trendyol.api_secret');
        $this->integrationCode = config('services.trendyol.integration_code');
    }

    /**
     * Get HTTP client instance configured for Trendyol API
     */
    protected function client()
    {
        // Trendyol Partner API kuralına göre: "SatıcıId - SelfIntegration"
        $userAgent = "{$this->sellerId} - SelfIntegration";
        
        return Http::withBasicAuth($this->apiKey, $this->apiSecret)
            ->withHeaders([
                'User-Agent' => $userAgent,
                'Accept' => 'application/json'
            ]);
    }

    /**
     * Fetch products from Trendyol
     *
     * @param int $page
     * @param int $size
     * @return array|null
     */
    public function getProducts(int $page = 0, int $size = 50, bool $approved = true): ?array
    {
        $endpoint = "{$this->baseUrl}/{$this->sellerId}/products";

        $response = $this->client()->get($endpoint, [
            'page' => $page,
            'size' => $size,
            'approved' => $approved ? 'true' : 'false'
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Trendyol getProducts API failed: ' . $response->body());
        
        return null;
    }

    /**
     * Fetch products from the newer Integration API gateway (apigw)
     */
    public function getIntegrationProducts(int $page = 0, int $size = 50): ?array
    {
        $endpoint = "https://apigw.trendyol.com/integration/product/sellers/{$this->sellerId}/products";

        $response = $this->client()->get($endpoint, [
            'page' => $page,
            'size' => $size,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Trendyol APIGW Integration API failed: ' . $response->body());
        return null;
    }
}
