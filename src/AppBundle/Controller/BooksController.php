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
        $books = $bookProvider->getAllBooks($this->getDoctrine());
        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($books, 'json');
        $view = $this->view($books, 200);
        return $this->handleView($view);
    }

    public function getBookAction(int $id): Response
    {
        $bookProvider = $this->get('aAppBundle\Provider\BooksProvider');
        $book = $bookProvider->getSingleBook( $id);
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
            $bookLogic = $this->get('appbundle\utils\books');
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
        $violations = $validator->validate($id, array(new NotBlank(),));
        if (0 !== count($violations)) {
            $view = $this->view('error', 200);

            return $this->handleView($view);
        }

        $authorsLogic = $this->get('appbundle\utils\books');

        $authorsLogic->delBook($this->getDoctrine(), $id);
        $view = $this->view('success', 200);

        return $this->handleView($view);
    }

    public function putPanelEditBookAction(Request $request, int $id): Response
    {
        $booksLogic = $this->get('appbundle\utils\books');
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