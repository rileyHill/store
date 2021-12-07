<?php

namespace App\Controller;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Form\OrderLineType;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/find", name="findOrder", methods={"GET"})
     */
    public function find(Request $request):Response{

        $id = $request->query->get('orderId');
        dump($id);
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->find($id);
        dump($order);
        if($order){
            return $this->render('order/order.html.twig',[
                'order'=>$order,
            ]);
        }
        $this->addFlash('notice','Not Exist!');
        return $this->redirect($this->generateUrl('searchOrder'));
    }

    /**
     * @Route("/order/delete",name="deleteOrder")
     */
    public function delete(Request $request):Response{
        //find object from database
//        $id = $request->query->get('id');
//        $order= $orderRepository->find($id);
        //find object from database
        $id = $request->query->get('id');
        dump($id);
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->find($id);

        if($order){
            $em = $this->getDoctrine()->getManager();
            $em->remove($order);
            $em->flush();

            $this->addFlash('notice','Removed Successfully!');
            //correct response
            return $this->redirect($this->generateUrl('homePage'));
        }

        $this->addFlash('notice','failed!');
        //correct response
        return $this->redirect($this->generateUrl('searchOrder'));
    }

    /**
     * @Route("/order/create", name="createOrder")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response{

        $order = new Order();
        $order->addOrderLine(new OrderLine());
        $form = $this->createForm(OrderType::class, $order);
        dump($order);
        $form->handleRequest($request);
//        $orderLine = new OrderLineType();

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            //event listener
//            $orderLine = $order->getOrderLines();
//
//            $event = new TotalAmountEvent($total, );
//            $dispatcher->dispatch($event,'change.TotalAmount');
//            $order->setTotalAmount($total);
//            //

            $em->persist($order);
            $em->flush();
//
            $this->addFlash('notice','Create Successfully!');
            return $this->redirect($this->generateUrl('homePage'));
        }
//
        return $this->render('order/createOrder.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/order/update/{id}", name="updateOrder")
     */
    public function update(int $id, Request $request): Response{
        dump($id);

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Order::class)->find($id);

        if (null === $order) {
            throw $this->createNotFoundException('No order found for id '.$id);
        }
        $originalOrderLines = new ArrayCollection();
        // Create an ArrayCollection of the current orderLines objects in the database
        foreach ($order->getOrderLines() as $line) {
            $originalOrderLines->add($line);
            $order->addOrderLine($line);
            $product = $line->getProduct();
        }

        $order->setOrderCode($order->getOrderCode());
        $order->setOrderDate($order->getOrderDate());
        $order->setCustomerName($order->getCustomerName());
        $order->setDescription($order->getDescription());

        $editForm = $this->createForm(OrderType::class, $order);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // remove the relationship between the tag and the Task
            foreach ($originalOrderLines as $line) {
                if (false === $order->getOrderLines()->contains($line)) {
                    $em->remove($line);
//                    $em->persist($line);
                }
            }
            $orderCode = $editForm['orderCode']->getData();
            $orderDate = $editForm['orderDate']->getData();
            $customerName = $editForm['customerName']->getData();
            $description = $editForm['description']->getData();

            $order->setOrderCode($orderCode);
            $order->setOrderDate($orderDate);
            $order->setCustomerName($customerName);
            $order->setDescription($description);

//            $em->persist($order);
            $em->flush();
            $this->addFlash('notice','Update Successfully!');
            // redirect back to some edit page
            return $this->render('order/order.html.twig', ['order' => $order]);
        }

        return $this->render('order/editOrder.html.twig', [
            'form' => $editForm->createView(),
        ]);
    }

}