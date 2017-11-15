<?php

namespace AppBundle\Controller;


use AppBundle\Form\AddAuthorsType;
use AppBundle\Form\EditAuthorType;
use AppBundle\Validator\Constraints\AuthorExist;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

/**
 * Class AuthorsCategory
 *
 * @package AppBundle\Controller
 */
class AuthorsController extends FOSRestController
{
    /**
     * This method return all authors
     *
     * @return Response
     */
    public function getAllAuthorsAction(): Response
    {
        $authorProvider = $this->get('AppBundle\Provider\AuthorProvider');
        $authors = $authorProvider->getAllAuthors();

        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($authors, 'json');
        $view = $this->view($authors, 200);
        return $this->handleView($view);
    }

    public function getAuthorAction(int $id): Response
    {
        $authorsLogic = $this->get('appbundle\utils\authors');
        $authors = $authorsLogic->getSingleAuthor($this->getDoctrine(), $id);
        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($authors, 'json');
        $view = $this->view($authors, 200);
        return $this->handleView($view);
    }

    public function putPanelAddAuthorAction(Request $request): Response
    {

        $form = $this->createForm(AddAuthorsType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $authorsLogic = $this->get('appbundle\utils\authors');
            $authorsLogic->addAuthor($this->getDoctrine(), $request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }

        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }

    public function deletePanelDelAuthorAction(Request $request, int $id): Response
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($id, array(new NotBlank(),));
        if (0 !== count($violations)) {
            $view = $this->view('error', 200);

            return $this->handleView($view);
        }
        $authorsLogic = $this->get('appbundle\utils\authors');

        $authorsLogic->delAuthor($this->getDoctrine(), $id);
        $view = $this->view('success', 200);

        return $this->handleView($view);
    }

    public function putPanelEditAuthorAction(Request $request, int $id): Response
    {
        $authorsLogic = $this->get('appbundle\utils\authors');

        if (!$authorsLogic->validateAuthor($id)) {
            $view = $this->view('error', 200);

            return $this->handleView($view);
        }

        $form = $this->createForm(EditAuthorType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted()) {
            $oldAuhtor = $authorsLogic->getSingleAuthor($this->getDoctrine(), $id);
            $authorsLogic->editAuthor($this->getDoctrine(), $oldAuhtor, $request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }
        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }
}