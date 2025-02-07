<?Php

namespace App\Controller;

use App\Service\PaypalService;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function pay(): JsonResponse
    {
        $order =$this->paypalService->createOrder(20.00,'EUR');

        if (!$order) {
            return $this->json(['error' => 'Erreur lors de la création du paiement'], 500);
        }

        return $this->json([
            'id' => $order['id'],
            'statuts' => $order['status'],
            'approval_url' => isset($order->links) && is_array($order->links) ? ($order->links[1]->href ?? null) : null,
        ]);

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
