<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 13.11.2017
 * Time: 18:54
 */

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