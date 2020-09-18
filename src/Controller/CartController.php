<?php


namespace App\Controller;


use App\Entity\Customer;
use App\Entity\Dish;
use App\Entity\Order;
use App\Form\OrderType;
use App\Service\CalculationManager;
use App\Service\ValidationManager;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     * @param SessionInterface $session
     * @param Request $request
     * @param CalculationManager $calculationManager
     * @param ValidationManager $validationManager
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function index(SessionInterface $session, Request $request, CalculationManager $calculationManager, ValidationManager $validationManager, MailerInterface $mailer)
    {
        $orderDetails = ($session->get('data'))->getOrderDetails();
        $entityManager = $this->getDoctrine()->getManager();
        $dishes = $entityManager->getRepository(Dish::class)->findBy([]);

        for ($i = 0; $i < count($dishes); $i++) {
            foreach ($orderDetails as $orderDetail) {
                if ($orderDetail->getFood()->getName() == $dishes[$i]->getName()) {
                    $orderDetail->setFood($dishes[$i]);
                }
            }
        }

        $order = new Order();
        foreach ($orderDetails as $orderDetail) {
            $order->addOrderDetail($orderDetail);
        }
        $order->setTotalPrice($calculationManager->check($order));
        $order->setRetrievalDatetime(new DateTime());

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();

            $customer = $entityManager->getRepository(Customer::class)->findOneBy(['name' => $data->getCustomer()->getName()]);
            if (isset($customer)) {
                $formMail = $order->getCustomer()->getEmail();
                $order->setCustomer($customer);
                if ($formMail !== null && $order->getCustomer()->getEmail() === 'NULL') {
                    $order->getCustomer()->setEmail($formMail);
                }
            }

            $errorMessages = $validationManager->validationLoopCustomer($order->getCustomer());
            if (!empty($errorMessages)) {
                return $this->render('cart/index.html.twig', [
                    'form' => $form->createView(),
                    'minErrors' => $errorMessages,
                    'order' => $order,
                    'orderDetails' => $orderDetails
                ]);
            }

            $entityManager->persist($order);
            $entityManager->flush();

            if ($order->getCustomer()->getEmail() != null) {
                $email = (new TemplatedEmail())
                    ->from($this->getParameter('mailer_from'))
                    ->to($order->getCustomer()->getEmail())
                    ->subject('Votre commande Oumami')
                    ->htmlTemplate('cart/email/confirmation.html.twig')
                    ->context([
                        'order' => $order
                    ])
                ;
                $mailer->send($email);
            }

            $session->remove('cart');
            $session->clear();

            $this->addFlash(
                'success',
                'La commande a bien été enregistrée.'
            );

            return $this->redirectToRoute('order');
        }

        return $this->render('cart/index.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
            'orderDetails' => $orderDetails
        ]);
    }
}
