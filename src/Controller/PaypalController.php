<?Php

namespace App\Controller;

use App\Service\PaypalService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaypalController extends AbstractController
{
    private $paypalService;

    public function __construct(PaypalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    #[Route('/pay', name: 'payment_paypal')]
    public function pay()
    {
        $payment = $this->paypalService->createPayment(20.00, $this->generateUrl('payment_success'), $this->generateUrl('payment_cancel'));

        if ($payment) {
            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    return new RedirectResponse($link->getHref());
                }
            }
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
