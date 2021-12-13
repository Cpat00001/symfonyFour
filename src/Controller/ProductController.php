<?php

namespace App\Controller;

use App\Entity\User;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/product")
*/

class ProductController extends AbstractController
{
   /**
     * @Route("/", name="product_index", methods={"GET"})
  */

    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    // public function new(Request $request): Response
    // {
    //     $product = new Product();
    //     $form = $this->createForm(ProductType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($product);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('product/new.html.twig', [
    //         'product' => $product,
    //         'form' => $form,
    //     ]);
    // }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product , CommentRepository $commentRepository): Response
    {
        // var_dump($product->getId());
        $prod_id = $product->getId();
        // echo "<br> Prod_ID";
        // var_dump($prod_id);
        // echo "<br>";
        $comments = $commentRepository->findAll();
        // var_dump($comments);
        // echo "<br><br>";
        //select all comments matching to current product_id/post_id and pass to template
        // simply show comments related to product/post -> NOT ALL Comments
        $selected_comments = $commentRepository->findBy(['product_id' => $prod_id ]);
        // echo "SELECTED COMMENTS<br>";
        // var_dump($selected_comments);
        // echo "<br>";
        foreach($comments as $comment){
            $comment_product_id = $comment->getProductId();
            // var_dump($comment_product_id);
        }
        //get logged User if logged In or set "exampleuser" if not loggedIn
        $user_ident = $this->getUser();
        
        if(is_null($user_ident)){
            $user_ident = "exampleuser@example.com";
            $user_email = "notregistered@user.com";
        }else{
        $user_ident = $this->getUser()->getUserIdentifier();
        $user_email = $this->getUser()->getEmail();
        }
        // var_dump($user_ident);

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'prod_id' => $prod_id,
            'user_ident' => $user_ident,
            'user_email' => $user_email,
            'comment_product_id' => $comment_product_id,
            'selected_comments' => $selected_comments,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    // public function edit(Request $request, Product $product): Response
    // {
    //     $form = $this->createForm(ProductType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('product/edit.html.twig', [
    //         'product' => $product,
    //         'form' => $form,
    //     ]);
    // }

    /**
     * @Route("/{id}", name="product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }
}
