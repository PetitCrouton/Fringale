<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

/**
 * Description of aboutusController
 *
 * @author Etudiant
 */
class AboutusController extends ControllerAbstract
{
    public function indexAction()
    {
        return $this->render("aboutus/index.html.twig");
    }
}
