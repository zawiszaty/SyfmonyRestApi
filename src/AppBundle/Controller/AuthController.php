<?php


namespace AppBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;

class AuthController extends FOSRestController
{
    public function getPanelAuthAction()
    {
        $view = $this->view('success', 200);
        return $this->handleView($view);
    }
}