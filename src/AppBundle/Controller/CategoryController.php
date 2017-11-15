<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Category;
use AppBundle\Form\AddCategoryType;
use AppBundle\Form\EditCategoryType;
use FOS\RestBundle\Controller\FOSRestController;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

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
     * @param Request $request
     *
     * @return Response
     */
    public function putPanelAddCategoryAction(Request $request): Response
    {
        $form = $this->createForm(AddCategoryType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryLogic = $this->get('appbundle\utils\category');
            $categoryLogic->addCategory($this->getDoctrine(), $request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }

        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }

    public function deletePanelDelCategoryAction(Request $request, int $id): Response
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($id, array(new NotBlank(),));
        if (0 !== count($violations)) {
            $view = $this->view('error', 200);

            return $this->handleView($view);
        }
        $authorsLogic = $this->get('appbundle\utils\category');

        $authorsLogic->delCategory($this->getDoctrine(), $id);
        $view = $this->view('success', 200);

        return $this->handleView($view);
    }

    public function putPanelEditCategoryAction(Request $request, int $id): Response
    {
        $authorsLogic = $this->get('appbundle\utils\category');
        $form = $this->createForm(EditCategoryType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted()) {

            $oldCategory = $authorsLogic->getSingleCategory($this->getDoctrine(), $id);
            $authorsLogic->editCategory($this->getDoctrine(), $oldCategory, $request->request->all());
            $view = $this->view('succes', 200);

            return $this->handleView($view);
        }
        $view = $this->view($form->getErrors(), 200);

        return $this->handleView($view);
    }
}