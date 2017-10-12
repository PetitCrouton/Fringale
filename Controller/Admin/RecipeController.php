<?php


namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Recipe;

class RecipeController extends ControllerAbstract
{
    public function listAction()
    {

        $recipes = $this->app['recipe.repository']->findAll();

        return $this->render(
            'admin/recipe/list.html.twig',
            [
                'recipes' => $recipes
            ]
        );
    }

    public function validateAction($id_recipe)
    {
        $recipe = $this->app['recipe.repository']->find($id_recipe);

        if (!$recipe instanceof Recipe) {
            $this->app->abort(404);
        }

        $this->app['recipe.repository']->validRecipe($recipe);

        $this->app['recipe.repository']->validateMail($id_recipe);

        $this->addFlashMessage('La recette est validée');

        return $this->redirectRoute('admin_recipes');
    }

    public function deleteAction($id_recipe)
    {
        $recipe = $this->app['recipe.repository']->find($id_recipe);

        if (!$recipe instanceof Recipe) {
            $this->app->abort(404);
        }

        $this->app['recipe.repository']->delete($recipe);

        $this->app['recipe.repository']->deleteMail($id_recipe);

        $this->addFlashMessage('La recette est supprimée. Un mail a été envoyé à l\'utilisateur.');

        return $this->redirectRoute('admin_recipes');
    }


}