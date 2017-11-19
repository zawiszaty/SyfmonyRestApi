<?php

namespace AppBundle\Controller;


use AppBundle\Form\AddAuthorsType;
use AppBundle\Form\EditAuthorType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * This method return only one author
     *
     * @param int $id author id
     *
     * @return Response
     */
    public function getAuthorAction(int $id): Response
    {
        $authorsLogic = $this->get('AppBundle\Provider\AuthorProvider');
        $authors = $authorsLogic->getSingleAuthor($id);
        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($authors, 'json');
        $view = $this->view($authors, 200);
        return $this->handleView($view);
    }

    /**
     * This method add new author
     *
     * @param Request $request request object
     *
     * @return Response
     */
    public function putPanelAddAuthorAction(Request $request): Response
    {

        $form = $this->createForm(AddAuthorsType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $authorsManager = $this->get('AppBundle\Manager\AuthorManager');
            $authorsManager->addAuthor($request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }

        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }

    /**
     * This method delete author
     *
     * @param Request $request request object
     * @param int $id id author
     *
     * @return Response
     */
    public function deletePanelDelAuthorAction(Request $request, int $id): Response
    {
        $authorsManager = $this->get('AppBundle\Manager\AuthorManager');
        $authorsManager->delAuthor($id);
        $view = $this->view('success', 200);
        return $this->handleView($view);
    }

    /**
     * This method changes author
     *
     * @param Request $request request object
     * @param int $id id author
     *
     * @return Response
     */
    public function putPanelEditAuthorAction(Request $request, int $id): Response
    {
        $form = $this->createForm(EditAuthorType::class);
        $form->submit($request->request->all() && $form->isValid());
        if ($form->isSubmitted() && $form->isValid()) {
            $authorsManager = $this->get('AppBundle\Manager\AuthorManager');
            $authorProvider = $this->get('AppBundle\Provider\AuthorProvider');
            $oldAuhtor = $authorProvider->getSingleAuthor($id);
            $authorsManager->editAuthor($oldAuhtor, $request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }
        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }
}