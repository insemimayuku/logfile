<?Php

namespace App\Controller;

use App\Service\PaypalService;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaypalController extends AbstractController
{
    private $paypalService;

    public function __construct(PaypalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    #[Route('/pay', name: 'payment_paypal')]
    public function pay(): RedirectResponse
    {
        $apiContext = $this->paypalService->getApiContext();

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal(20.00)
            ->setCurrency('USD');

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('Paiement de 20$ avec PayPal');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->generateUrl('payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL))
            ->setCancelUrl($this->generateUrl('payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL));

        $payment = new Payment();
        $payment->setIntent('sale')
        ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() === 'approval_url') {
                    return new RedirectResponse($link->getHref());
                }
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de la création du paiement.');
        }

        return $this->redirectToRoute('payment_failed');
    }


    #[Route('/payment/success', name: 'payment_success')]
    public function success()
    {
        // Logique de succès du paiement
    }

    #[Route('/payment/cancel', name: 'payment_cancel')]
    public function cancel()
    {
        // Logique en cas d'annulation du paiement
    }

    #[Route('/payment/failed', name: 'payment_failed')]
    public function failed()
    {
        // Logique en cas d'échec du paiement
    }
}
