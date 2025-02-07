<?php 

namespace App\Service;

use PayPal\Api\Amount;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalService{
    private $apiContext;

    public function __construct(String $clientID, String $secret, $mode){
        $this->apiContext = new ApiContext(new OAuthTokenCredential($clientID,$secret));
        $this->apiContext->setConfig(['mode' => $mode,  // 'sandbox' ou 'live'
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => '../var/logs/paypal.log',
            'log.LogLevel' => 'DEBUG'
        ]);
    }


    public function getApiContext(): ApiContext
    {
        return $this->apiContext;
    }

    public function createPayment(float $totalAmount, string $returnUrl, string $cancelUrl){
        
        $payer = new Payer();

        $payer->setPaymentMethod('paypal');

        $itemList =new ItemList();
        $Amount = new Amount();
        $Amount->setTotal($totalAmount)->setCurrency('EUR');

        $transaction = new Transaction();

        $transaction->setAmount($Amount)
        ->setItemList($itemList)
        ->setDescription('Payment du stokage');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($returnUrl)
        ->setCancelUrl($cancelUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            
            return $payment;
        } catch (\Exception $e) {
            return null;


    }
}

public function executePayment($paymentId, $payerId, ){
    
    $payement = Payment::get($paymentId,$this->apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($payerId);

    try {
        $payement->execute($execution, $this->apiContext);

        return $payement;
        
    } catch (\Exception $e) {
        return null;
    }
}



}