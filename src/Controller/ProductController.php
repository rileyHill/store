<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * @Route("/product/update/{id}", name="updateProduct")
     * @param int $id
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function update(int $id, Request $request, ProductRepository $productRepository): Response
    {
//        $product= $this->getDoctrine()->getRepository('App:Product')->find($id);
        $product= $productRepository->find($id);
        $product->setName($product->getName());
        $product->setPrice($product->getPrice());
        $product->setCode($product->getCode());
        $product->setDescription($product->getDescription());

        $editForm = $this->createForm(ProductType::class, $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()){
            $name = $editForm['name']->getData();
            $price = $editForm['price']->getData();
            $code = $editForm['code']->getData();
            $description = $editForm['description']->getData();

            $em = $this->getDoctrine()->getManager();
            $product= $productRepository->find($id);
            $product->setName($name);
            $product->setPrice($price);
            $product->setCode($code);
            $product->setDescription($description);

//            $em->persist($product);
            $em->flush();

            return $this->render('product/product.html.twig', ['product' => $product]);
//            return $this->generateUrl('product/product.html.twig', [
//            'product'=> $product,
//            ]);
        }

        return $this->render('product/createProduct.html.twig', [
            'form' => $editForm->createView(),
        ]);
    }

    /**
     * @Route("/product/create", name="createProduct")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $product= new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('notice','Create Successfully!');
            return $this->redirect($this->generateUrl('homePage'));
        }

        return $this->render('product/createProduct.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/product/find", name="findProduct", methods={"GET"})
     */
    public function find(Request $request, ProductRepository $productRepository):Response{
        //find object from database
        $id = $request->query->get('productId');
        dump($id);
//        $product = $this->getDoctrine()
//            ->getRepository(Product::class)
//            -
        /** @var Product $product */
        $product = $productRepository->find($id);
        dump($product);

        if($product){
            return $this->render('product/product.html.twig', [
                'product' => $product,
                ]);
//            return $this->render('product/product.html.twig', ['obj'=>$product]);
//            return $this->render('product/product.html.twig',array('product'=>$product));
        }
        $this->addFlash('notice','Not Exist!');
        return $this->redirect($this->generateUrl('searchProduct'));
    }

    /**
     * @Route("/product/delete",name="deleteProduct")
     */
    public function delete(Request $request):Response{
        //find object from database
        $id = $request->query->get('id');
        dump($id);
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if($product){
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
            //correct response
            return $this->redirect($this->generateUrl('homePage'));
        }
        echo ("Didnt exist!");
        $this->addFlash('notice','Didnt exist!');
        return $this->redirect($this->generateUrl('searchProduct'));
    }



}