<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
    $twig->addGlobal('user_manager', $app['user.manager']);

    $gravatarFilter = new Twig_SimpleFilter('gravatar_hash', function ($string) {
        return md5(strtolower($string));
    });

    $twig->addFilter($gravatarFilter);

    return $twig;
});

// Ajout doctrine DBAL ($app['db'])
// Nécessite l'installation par composer : composer require doctrine/dbal:~2.2
// en ligne de commande dans le repertoire de l'application
$app->register(new DoctrineServiceProvider(),
    [
        'db.options'    => [
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'projet_v1',
            'user'      => 'root',
            'password'  => 'root',
            'charset'   => 'utf8'
        ]
    ]);
$app->register(new Silex\Provider\SessionServiceProvider());

/* CONTROLLERS */


//----------------------------- BACK ---------------------------------//

$app['admin.user.controller'] = function() use ($app){
    return new \Controller\Admin\UserController($app);
};
$app['admin.recipe.controller'] = function() use ($app){
    return new \Controller\Admin\RecipeController($app);
};
$app['admin.region.controller'] = function() use ($app){
    return new \Controller\Admin\RegionController($app);
};
$app['admin.comment.controller'] = function() use ($app){
    return new \Controller\Admin\CommentController($app);
};

//----------------------------- REPOSITORIES ---------------------------------//

/* AUTRES SERVICES */
$app['user.manager'] = function() use ($app){
    return new Service\UserManager($app['session']);
};

$app['user.repository'] = function() use ($app){
    return new \Repository\UserRepository($app);
};


// $app['session'] = gestionnaire de session de symfony
$app->register(new Silex\Provider\SessionServiceProvider());


/* CONTROLLERS */

//----------------------------- FRONT ---------------------------------//
$app['user.controller'] = function() use ($app){
    return new \Controller\UserController($app);
};

$app['region.controller'] = function() use ($app){
    return new \Controller\RegionController($app);
};

$app['index.controller'] = function () use ($app)
{
    return new \Controller\IndexController($app);
};

$app['recipe.controller'] = function () use ($app)
{
    return new \Controller\RecipeController($app);
};
$app['contact.controller'] = function () use ($app)
{
    return new \Controller\ContactController($app);
};

$app['aboutus.controller'] = function () use ($app)
{
    return new \Controller\AboutusController($app);
};

$app['termsofuse.controller'] = function () use ($app)
{
    return new \Controller\TermsofuseController($app);
};

//-------------------------REPOSITORIES---------------------------------//
//
$app['region.repository'] = function() use ($app){
    return new \Repository\RegionRepository($app);
};

$app['recipe.repository'] = function() use ($app)
{
    return new \Repository\RecipeRepository($app);
};
$app['regiondetail.repository'] = function () use ($app)
{
    return new \Repository\RegionDetailRepository($app);
};
$app['comment.repository'] = function () use ($app)
{
    return new \Repository\CommentRepository($app);
};
$app['rating.repository'] = function () use ($app)
{
    return new \Repository\RatingRepository($app);
};

return $app;

