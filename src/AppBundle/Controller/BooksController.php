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
        $bookLogic = $this->get('AppBundle\Utils\Books');
        $books = $bookLogic->getAllBooks($this->getDoctrine());
        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($books, 'json');
        $view = $this->view($books, 200);
        return $this->handleView($view);
    }

    public function getBookAction(int $id): Response
    {
        $bookLogic = $this->get('AppBundle\Utils\Books');
        $book = $bookLogic->getSingleBook($this->getDoctrine(), $id);
        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($book, 'json');
        $view = $this->view($book, 200);
        return $this->handleView($view);
    }

    /**
     * This method added new books
     *
     * @return Response
     */
    public function putPanelAddBookAction(Request $request): Response
    {
        $form = $this->createForm(AddBooksType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $bookLogic = $this->get('AppBundle\Utils\Books');
            $bookLogic->addBooks($this->getDoctrine(), $request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }

        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }

    public function deletePanelDelBookAction(Request $request, int $id): Response
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($id, array(
            new NotBlank(),
        ));
        if (0 !== count($violations)) {
            $view = $this->view('error', 200);

            return $this->handleView($view);
        }

        $authorsLogic = $this->get('AppBundle\Utils\Books');

        $authorsLogic->delBook($this->getDoctrine(), $id);
        $view = $this->view('success', 200);

        return $this->handleView($view);
    }

    public function putPanelEditBookAction(Request $request, int $id): Response
    {
        $booksLogic = $this->get('AppBundle\Utils\Books');
        $form = $this->createForm(EditBookType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted()) {

            $oldBook = $booksLogic->getSingleBook($this->getDoctrine(), $id);
            $booksLogic->editBook($this->getDoctrine(), $oldBook, $request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }
        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }
}