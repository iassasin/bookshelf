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

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $bookRep = $this->getDoctrine()->getRepository(Book::class);

        return $this->render('home/index.html.twig', [
            'books' => $bookRep->findAll(),
        ]);
    }
}
