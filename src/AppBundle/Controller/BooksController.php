<?php

namespace AppBundle\Controller;

use AppBundle\Form\AddBooksType;
use AppBundle\Form\EditBookType;
use FOS\RestBundle\Controller\FOSRestController;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

/**
 * Class BooksController
 *
 * @package AppBundle\Controller
 */
class BooksController extends FOSRestController
{
    /**
     * This method response all books
     *
     * @return Response
     */
    public function getAllBooksAction(): Response
    {
        $bookProvider = $this->get('AppBundle\Provider\BooksProvider');
        $books = $bookProvider->getAllBooks();
        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($books, 'json');
        $view = $this->view($books, 200);
        return $this->handleView($view);
    }

    /**
     * This method return only one id
     *
     * @param int $id book id
     *
     * @return Response
     */
    public function getBookAction(int $id): Response
    {
        $bookProvider = $this->get('AppBundle\Provider\BooksProvider');
        $book = $bookProvider->getSingleBook( $id);
        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($book, 'json');
        $view = $this->view($book, 200);
        return $this->handleView($view);
    }

    /**
     * This method added new books
     *
     * @param Request $request request object
     *
     * @return Response
     */
    public function putPanelAddBookAction(Request $request): Response
    {
        $form = $this->createForm(AddBooksType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $booksManager = $this->get('AppBundle\Manager\BooksManager');
            $booksManager->addBooks($request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }

        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }

    /**
     * This method delete book
     *
     * @param Request $request request object
     * @param int $id book id
     *
     * @return Response
     */
    public function deletePanelDelBookAction(Request $request, int $id): Response
    {
        $booksManager = $this->get('AppBundle\Manager\BooksManager');
        $booksManager->delBook($id);
        $view = $this->view('success', 200);
        return $this->handleView($view);
    }

    /**
     * This method changes book
     *
     * @param Request $request request object
     * @param int $id book id
     *
     * @return Response
     */
    public function putPanelEditBookAction(Request $request, int $id): Response
    {
        $form = $this->createForm(EditBookType::class);
        $form->submit($request->request->all() && $form->isValid());
        if ($form->isSubmitted()) {
            $booksProvider = $this->get('AppBundle\Provider\BooksProvider');
            $booksManager = $this->get('AppBundle\Manager\BooksManager');
            $oldBook = $booksProvider->getSingleBook($id);
            $booksManager->editBook($oldBook, $request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }
        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }
}