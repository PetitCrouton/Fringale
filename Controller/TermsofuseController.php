<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 22/08/2017
 * Time: 10:40
 */

namespace Controller;


class TermsofuseController extends ControllerAbstract
{
    public function indexAction()
    {
        return $this->render("termsofuse/index.html.twig");
    }
}