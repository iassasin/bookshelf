<?php

namespace AppBundle\Controller\Api\v1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use AppBundle\Entity\Book;
use AppBundle\Entity\User;

class BooksController extends Controller
{
    /**
     * @Route("/books")
     */
    public function listAction(Request $request, SerializerInterface $jms)
    {
        $bookRep = $this->getDoctrine()->getRepository(Book::class);
        $books = $bookRep->findBy([], ['readDate' => 'DESC']);

        $ctx = SerializationContext::create()->setGroups(['list']);

        return new Response($jms->serialize($books, 'json', $ctx), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/books/{bookId}/edit", requirements={"bookId": "\d+"})
     */
    public function editAction($bookId, Request $request, SerializerInterface $jms)
    {
        $bookRep = $this->getDoctrine()->getRepository(Book::class);
        $book = $bookRep->findOneById($bookId);

        if ($book === null) {
            return new Response(
                $jms->serialize(['result' => false, 'info' => 'book not found'], 'json'),
                200,
                ['Content-Type' => 'application/json']
            );
        }

        $ctx = DeserializationContext::create()->setGroups(['edit']);
        $sbook = $jms->deserialize($request->getContent(), 'AppBundle\Entity\Book', 'json', $ctx);

        if ($sbook->getName() !== null) {
            $book->setName($sbook->getName());
        }
        if ($sbook->getAuthor() !== null) {
            $book->setAuthor($sbook->getAuthor());
        }
        if ($sbook->getReadDate()) {
            $book->setReadDate($sbook->getReadDate());
        }
        if ($sbook->getIsDownloadable() !== null) {
            $book->setIsDownloadable($sbook->getIsDownloadable());
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response($jms->serialize(['result' => true], 'json'), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/books/add")
     */
    public function addAction(Request $request, SerializerInterface $jms)
    {
        $bookRep = $this->getDoctrine()->getRepository(Book::class);

        $ctx = DeserializationContext::create()->setGroups(['edit']);

        $book = $jms->deserialize($request->getContent(), 'AppBundle\Entity\Book', 'json', $ctx);
        $book->setCoverPath('');
        $book->setBookPath('');

        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        return new Response(
            $jms->serialize(['id' => $book->getId()], 'json'),
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
