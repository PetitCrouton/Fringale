<?php

namespace Controller;


use Silex\Application;

abstract class ControllerAbstract
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->twig = $app['twig'];
        $this->session = $app['session'];
    }

    /**
     * @param string $view
     * @param array $parameters
     * @return string
     */
    public function render($view, array $parameters = [])
    {
        return $this->twig->render($view, $parameters);
    }

    /**
     * @param string $routeName
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectRoute($routeName, array $parameters = [])
    {
        return $this->app->redirect($this->app['url_generator']->generate($routeName, $parameters));
    }

    public function addFlashMessage($message, $type = 'success')
    {
        $this->session->getFlashBag()->add($type, $message);
    }

}