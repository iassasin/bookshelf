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
use AppBundle\Service\FileStorage;

class BookController extends Controller
{
    /**
     * @Route("/book/add", name="book_add")
     */
    public function bookAddAction(Request $request, FileStorage $storage)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($book->getCoverFile() != null) {
                $book->setCoverPath($storage->upload($book->getCoverFile()));
            }

            if ($book->getBookFile() != null) {
                $book->setBookPath($storage->upload($book->getBookFile()));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/book/delete/{bookId}", name="book_delete", requirements={"bookId": "\d+"})
     */
    public function bookDeleteAction($bookId, Request $request, FileStorage $storage)
    {
        $em = $this->getDoctrine()->getManager();
        $bookRep = $this->getDoctrine()->getRepository(Book::class);
        $book = $bookRep->findOneById($bookId);

        if ($book == null) {
            return $this->render('error.html.twig', [
                'title' => 'Edit book',
                'message' => 'Book not found!',
            ]);
        }

        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
