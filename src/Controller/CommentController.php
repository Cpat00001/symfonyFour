<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="comment_index", methods={"GET"})
     * @ParamConverter("product", class="SensioBlogBundle:Product")
     */ 
    public function index(CommentRepository $commentRepository): Response
    {
        //check if the user is loggedIn and what is his identifier
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $user_email = $user->getEmail();
        // var_dump($product);
        echo "<br><br>";
        // var_dump($user_email);
        $matching_comments = $commentRepository->findBy(['product_id' => $user_email]);
        var_dump($commentRepository->findAll());
        echo "SELECETED <br><br>";
        var_dump($matching_comments);

        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
            'user_email' => $user_email,
        ]);
    }

    /**
     * @Route("/new/{post_id}/{user_ident}", name="comment_new", methods={"GET","POST"})
     */
    // public function new(Request $request): Response
    public function new(Request $request , $post_id , $user_ident): Response
    {
        // check if user loggedIn and have ROLE_USER
        $this->denyAccessUnlessGranted('ROLE_USER');

        var_dump($post_id);
        var_dump($user_ident);

        $comment = new Comment();
        $comment->setUser($user_ident);
        $comment->setProductId($post_id);
        var_dump($comment);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
            // return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            // 'post_id' => $post_id,
            // 'user_id' => $user_id, 
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="comment_show", methods={"GET"})
     */
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="comment_delete", methods={"POST"})
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
