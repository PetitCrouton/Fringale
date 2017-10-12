<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 10/08/2017
 * Time: 17:02
 */

namespace Controller;



class IndexController extends ControllerAbstract
{
    public function indexAction()
    {
        $regions = $this->app['region.repository']->findAll();


        return $this->render('index.html.twig',
            [
                'regions' => $regions,
            ]
        );
    }

    public function footerAction(){
        $recipesCount = $this->app['recipe.repository']->totalRecipes();
        $usersCount = $this->app['user.repository']->totalUsers();

        return $this->render('footer.html.twig',
            [
                'recipesCount' => $recipesCount,
                'usersCount'    => $usersCount,
            ]
        );
    }
}
