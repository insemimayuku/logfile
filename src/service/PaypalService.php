<?php

namespace App\Service;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\LiveEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PaypalService
{
    private PayPalHttpClient $client;

    public function __construct(string $clientId, string $secret, string $mode)
    {
        $environment = ($mode === 'sandbox' )? (new SandboxEnvironment($clientId, $secret)) : (new LiveEnvironment($clientId, $secret));

        $this->client = new PayPalHttpClient($environment);
    }

    public function createOrder(float $amount, string $currency = 'EUR')
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => $currency,
                    "value" => number_format($amount, 2, '.', '')
                ]
            ]]
        ];

        try {
            $response = $this->client->execute($request);
            return $response->result;
        } catch (\Exception $e) {
            return null;
        }
    }
}
