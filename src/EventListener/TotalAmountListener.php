<?php

namespace App\EventListener;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\Product;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class TotalAmountListener
{

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Order) {
            return;
        }
        $total = 0;
        $entityManager = $args->getEntityManager();
        dump($entity);
        $orderLineRep = $entityManager->getRepository(OrderLine::class);
        $lines = $entity->getOrderLines();
//        $lines = $orderLineRep->findBy(['orders_id'=>$id]);
//        $rate = $HRrepo->findHourlyRateByDate($log->getDate(), $log->getUser());

//        $orderLine = $entity->getOrderLines();
        dump($lines);
        foreach ($lines as $line){
            $total += $line->getPayablePrice();
        }

        $entity->setTotalAmount($total);
    }

//    public function postFlush(PostFlushEventArgs $args): void
//    {
//        $entity = $args->getEntityManager();
//
//        if (!$entity instanceof Order) {
//            return;
//        }
//        $total = 0;
//        $entityManager = $args->getEntityManager();
//        dump($entity);
//        $orderLineRep = $entityManager->getRepository(OrderLine::class);
//        $id = $entity->getId();
//        dump($id);
//        $lines = array($entity->getOrderLines());
////        $lines = $orderLineRep->findBy(['orders_id'=>$id]);
////        $rate = $HRrepo->findHourlyRateByDate($log->getDate(), $log->getUser());
//
////        $orderLine = $entity->getOrderLines();
//        dump($lines);
//        foreach ($lines as $line){
//            $total += $line->getPayablePrice();
//        }
//
//        $entity->setTotalAmount($total);
//    }
//
//    public function preUpdate(PreUpdateEventArgs $args): void
//    {
//        $entity = $args->getEntity();
//
//        if (!$entity instanceof Order) {
//            return;
//        }
//        $total = 0;
//        $entityManager = $args->getEntityManager();
//        dump($entity);
//        $orderLineRep = $entityManager->getRepository(OrderLine::class);
//        $id = $entity->getId();
//        dump($id);
//        $lines = array($entity->getOrderLines());
////        $lines = $orderLineRep->findBy(['orders_id'=>$id]);
////        $rate = $HRrepo->findHourlyRateByDate($log->getDate(), $log->getUser());
//
////        $orderLine = $entity->getOrderLines();
//        dump($lines);
//        foreach ($lines as $line){
//            $total += $line->getPayablePrice();
//        }
//
//        $entity->setTotalAmount($total);
//    }

//    public function postPersist(LifecycleEventArgs $args): void
//    {
//        $entity = $args->getEntity();
//
//        if (!$entity instanceof Order) {
//            return;
//        }
//        $total = 0;
//        $entityManager = $args->getEntityManager();
//        dump($entity);
//        $orderLineRep = $entityManager->getRepository(OrderLine::class);
//        $lines = array($entity->getOrderLines());
//        $id = $entity->getId();
//        dump($id);
////        $lines = $orderLineRep->findBy(['orders_id'=>$id]);
////        $rate = $HRrepo->findHourlyRateByDate($log->getDate(), $log->getUser());
//
////        $orderLine = $entity->getOrderLines();
//        dump($lines);
//        foreach ($lines as $line){
//            $total += $line->getPayablePrice();
//        }
//
//        $entity->setTotalAmount($total);
//    }
}