<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends Controller
{

    /**
     * @Route("/", name="product_index", methods="GET")
     * @param \App\Repository\ProductRepository $productRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ProductRepository $productRepository): Response
    {
        $this->addFlash(
          'notice',
          'Your changes were saved!'
        );
        return $this->render('product/index.html.twig',
          ['products' => $productRepository->findAll()]);
    }

    /**
     * @Route("/new", name="product_new", methods="GET|POST")
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
          'product' => $product,
          'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods="GET")
     * @param \App\Entity\Product $product
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods="GET|POST")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Entity\Product                       $product
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit',
              ['id' => $product->getId()]);
        }

        return $this->render('product/edit.html.twig', [
          'product' => $product,
          'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="product_delete", methods="DELETE")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Entity\Product                       $product
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(),
          $request->request->get('_token'))
        ) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
