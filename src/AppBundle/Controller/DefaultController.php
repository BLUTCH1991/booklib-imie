<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $categories = $this->getDoctrine()->getRepository("AppBundle:Category")->findAll();
        $lastBooks = $this->getDoctrine()->getRepository("AppBundle:Book")->findLast(3);
        $users = $this->getDoctrine()->getRepository("AppBundle:User")->findLastUser(5);

        return $this->render('default/index.html.twig', [
                    "categories" => $categories,
                    "lastBooks" => $lastBooks,
                    "users" => $users
        ]);
    }

    /**
     * @Route("/book/{slug}", name="show_book")
     */
    public function showBookAction(\AppBundle\Entity\Book $book) {
        $otherBooks = $this->getDoctrine()->getRepository("AppBundle:Book")->getRandomBooks($book->getId());
        $lastBorrow = $this->getDoctrine()->getRepository("AppBundle:Book")->getLastBorrow($book->getId());

        return $this->render('book/show.html.twig', [
                    "book" => $book,
                    "otherBooks" => $otherBooks,
                    "lastBorrow" => $lastBorrow
        ]);
    }

    /**
     * @Route("/category/{id}", name="show_category")
     */
    public function showCategoryAction(\AppBundle\Entity\Category $category) {
        return $this->render('category/show.html.twig', [
                    "category" => $category
        ]);
    }

}
