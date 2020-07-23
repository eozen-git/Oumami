<?php


namespace App\Controller;


use App\Entity\Customer;
use App\Entity\Dish;
use App\Entity\Order;
use App\Form\OrderType;
use App\Service\CalculationManager;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     * @param SessionInterface $session
     * @param Request $request
     * @param CalculationManager $calculationManager
     * @return Response
     * @throws Exception
     */
    public function index(SessionInterface $session, Request $request, CalculationManager $calculationManager)
    {
        $orderDetails = ($session->get('cart'))->getOrderDetails();
        $entityManager = $this->getDoctrine()->getManager();
        $dishes = $entityManager->getRepository(Dish::class)->findBy([]);

        for ($i = 0; $i < count($dishes); $i++) {
            foreach ($orderDetails as $orderDetail) {
                if ($orderDetail->getFood()->getName() == $dishes[$i]-> getName()) {
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

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $customer = $entityManager->getRepository(Customer::class)->findOneBy(['email' => $data->getCustomer()->getEmail()]);
            if (isset($customer)) {
                $order->setCustomer($customer);
            }

            $entityManager->persist($order);
            $entityManager->flush();
        }

        return $this->render('cart/index.html.twig', [
            'form' => $form->createView(),
            'order' => $order
        ]);
    }
}
