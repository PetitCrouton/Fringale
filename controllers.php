<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));


/******************** FRONT *****************************/

$app->get('/', 'index.controller:indexAction')->bind('homepage');

$app->match('/recipe/create', 'recipe.controller:createAction')->bind('recipe_create');

$app->match('/recipe/list', 'recipe.controller:listAction')->bind('recipe_list');

$app->match('/recipe/search-ajax', 'recipe.controller:searchAjaxAction')->bind('recipe_search_ajax');

$app->match('/recipe/rating-ajax', 'recipe.controller:ratingAjaxAction')->bind('recipe_rating_ajax');

//$app->match('/recipe/comment-ajax', 'recipe.controller:commentAjaxAction')->bind('recipe_comment_ajax');

$app->match('/recipe/index/{id_recipe}', 'recipe.controller:indexAction')->bind('recipe_index');

$app->match('/region/index', 'region.controller:indexAction')->bind('region_index');

$app->match('/region/index/{id_region}', 'region.controller:indexAction')->bind('region_index');

$app->match('/contact/index', 'contact.controller:contactAction')->bind('contact_index');

$app->match('/aboutus/index','aboutus.controller:indexAction')->bind('aboutus_index');

$app->match('/termsofuse/index','termsofuse.controller:indexAction')->bind('termsofuse_index');

$app
    ->match('/utilisateur/inscription', 'user.controller:registerAction')
    ->bind('user_register');

$app
    ->match('/utilisateur/connexion', 'user.controller:loginAction')
    ->bind('user_login');

$app
    ->get('/utilisateur/profil', 'user.controller:profilAction')
    ->bind('user_profil');

$app
    ->match('/utilisateur/profil/edition', 'user.controller:profilEditAction')
    ->bind('profil_edit');

$app
    ->get('/utilisateur/profil/public/{id_user}', 'user.controller:profilPublicAction')
    ->assert('id', '\d+')
    ->bind('user_profil_public');

$app
    ->match('/utilisateur/deconnexion', 'user.controller:logoutAction')
    ->bind('user_logout');

$app
    ->get('/recettes/utilisateur/{id_user}', 'recipe.controller:userRecipeAction')
    ->bind('recipes_user');

$app
    ->get('/menu/regions', 'region.controller:menuAction')
    ->bind('menu_regions')
;
$app
    ->get('/footer/count', 'index.controller:footerAction')
    ->bind('footer_counts')
;

/******************** BACK ******************************/

// créé un groupe de routes
$admin = $app['controllers_factory'];

// Pour toutes les routes du groupe, si on n'est
// pas connecté en admin, page 403
$admin->before(function () use ($app) {
    if (!$app['user.manager']->isAdmin()) {
        $app->abort(403, 'Acces refusé');
    }
});

$app->mount('/admin', $admin);

//-------------- USER
$admin ->get('/utilisateurs', 'admin.user.controller:listAction') ->bind('admin_users');

$admin ->match('/utilisateur/edition/{id_user}', 'admin.user.controller:editAction')
    ->value('id_user', null) // valeur par défaut pour l'id
    ->bind('admin_user_edit')
;

$admin ->get('/utilisateur/suppression/{id_user}', 'admin.user.controller:deleteAction')
    ->assert('id_user','\d+') // id doit être un nombre
    ->bind('admin_user_delete')
;

//------------- RECIPE
$admin ->get('/recettes', 'admin.recipe.controller:listAction') ->bind('admin_recipes');

$admin
    ->match('/recette/valider/{id_recipe}', 'admin.recipe.controller:validateAction')
    ->value('id_user', null) // valeur par défaut pour l'id
    ->bind('admin_recipe_validate')
;

$admin ->get('/recette/suppression/{id_recipe}', 'admin.recipe.controller:deleteAction')
    ->assert('id_recipe','\d+') // id doit être un nombre
    ->bind('admin_recipe_delete')
;

//------------- REGION
$admin ->get('/regions', 'admin.region.controller:listAction') ->bind('admin_regions');

$admin ->match('/region/edition/{id_region}', 'admin.region.controller:editAction')
    ->value('id_region', null) // valeur par défaut pour l'id
    ->bind('admin_region_edit') ;

$admin ->get('/region/suppression/{id_region}', 'admin.region.controller:deleteAction')
    ->assert('id_region','\d+') // id doit être un nombre
    ->bind('admin_region_delete') ;

//------------- COMMENTS
$admin
    ->get('/comments', 'admin.comment.controller:listAction')
    ->bind('admin_comments')
;

$admin
    ->get('/comment/suppression/{id_comment}', 'admin.comment.controller:deleteAction')
    ->assert('id_comment','\d+') // id doit être un nombre
    ->bind('admin_comment_delete')
;

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/' . $code . '.html.twig',
        'errors/' . substr($code, 0, 2) . 'x.html.twig',
        'errors/' . substr($code, 0, 1) . 'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
