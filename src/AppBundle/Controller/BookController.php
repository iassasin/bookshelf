<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Book;
use AppBundle\Entity\User;
use AppBundle\Form\BookType;

class BookController extends Controller
{
    /**
     * @Route("/book/add", name="book_add")
     */
    public function bookAddAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $book->setCoverFile('cover new');
            $book->setBookFile('book new');

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
