<?php

namespace AppBundle\Controller;

use AppBundle\Form\AddCategoryType;
use AppBundle\Form\EditCategoryType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController
 *
 * @package AppBundle\Controller
 */
class CategoryController extends FOSRestController
{

    /**
     * This method return all category
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllCategoryAction(): Response
    {
        $categoryProvider = $this->get('AppBundle\Provider\CategoryProvider');
        $category = $categoryProvider->getAllCategory();
        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($category, 'json');
        $view = $this->view($category, 200);
        return $this->handleView($view);
    }

    /**
     * This method return only one category
     *
     * @param int $id category id
     *
     * @return Response
     */
    public function getCategoryAction(int $id): Response
    {
        $categoryProvider = $this->get('AppBundle\Provider\CategoryProvider');
        $category = $categoryProvider->getSingleCategory($id);
        $serializer = $this->container->get('jms_serializer');
        $serializer->serialize($category, 'json');
        $view = $this->view($category, 200);
        return $this->handleView($view);
    }

    /**
     * This method added new category
     *
     * @param Request $request request object
     *
     * @return Response
     */
    public function putPanelAddCategoryAction(Request $request): Response
    {
        $form = $this->createForm(AddCategoryType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryManager = $this->get('AppBundle\Manager\CategoryManager');
            $categoryManager->addCategory($request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }

        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }

    /**
     * This method delete category
     *
     * @param Request $request request object
     * @param int $id id category
     *
     * @return Response
     */
    public function deletePanelDelCategoryAction(Request $request, int $id): Response
    {
        $categoryManager = $this->get('AppBundle\Manager\CategoryManager');

        $categoryManager->delCategory($id);
        $view = $this->view('success', 200);

        return $this->handleView($view);
    }

    /**
     * This method changes category
     *
     * @param Request $request request object
     * @param int $id category id
     *
     * @return Response
     */
    public function putPanelEditCategoryAction(Request $request, int $id): Response
    {
        $form = $this->createForm(EditCategoryType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted()) {
            $categoryManager = $this->get('AppBundle\Manager\CategoryManager');
            $categoryProvider = $this->get('AppBundle\Provider\CategoryProvider');
            $oldCategory = $categoryProvider->getSingleCategory($id);
            $categoryManager->editCategory($oldCategory, $request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }
        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }
}