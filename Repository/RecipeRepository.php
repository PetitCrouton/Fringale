<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 10/08/2017
 * Time: 10:07
 */

namespace Repository;

use Entity\Recipe;

class RecipeRepository extends RepositoryAbstract
{
    protected function getTable()
    {
        return 'recipes';
    }

    public function findAll()
    {
        $query = "SELECT r.*, s.region_name, u.username FROM recipes r"
            . " JOIN regions s ON r.id_region = s.id_region"
            . " JOIN users u ON r.id_user = u.id_user"
            . " WHERE r.status = 'En attente'"
            . "ORDER BY r.date_recipe"
        ;

        $dbRecipes = $this->db->fetchAll($query);

        $recipes = [];

        foreach ($dbRecipes as $dbRecipe) {
            $recipe = $this->buildEntity($dbRecipe);

            $recipes[] = $recipe;
        }

        return $recipes;
    }

    public function findSort($orderField = 'username', $order = 'ASC')
    {
        $query = "SELECT r.*, s.region_name, u.username FROM recipes r"
            . " JOIN regions s ON r.id_region = s.id_region"
            . " JOIN users u ON r.id_user = u.id_user"
        ;

        $query .= " ORDER BY $orderField $order";

        $dbRecipes = $this->db->fetchAll($query);

        $recipes = [];

        foreach ($dbRecipes as $dbRecipe)
        {
            $recipe = $this->buildEntity($dbRecipe);

            $recipes[] = $recipe;
        }

        return $recipes;
    }

    public function deleteMail($id_recipe)
    {
        $query = 'SELECT r.*, u.username, u.email FROM recipes r JOIN users u ON r.id_user = u.id_user WHERE id_recipe = :id_recipe';

        $dbMail = $this->db->fetchAssoc($query, [':id_recipe' => $id_recipe]);

        if(!empty($dbMail)){

            // Subject of confirmation email.
            $subject = 'Suppression de votre recette';

            // Who should the confirmation email be from?
            $sender = 'J\'ai faim! <no-reply@myemail.co.uk>';

            $msg = $dbMail['username'] . ",\n\nNous jugeons votre recette inappropriée et nous l'avons donc supprimée.
            <br />";

            @mail($dbMail['email'], $subject, $msg, 'From: ' . $sender);
        }
    }

    /*public function creationMail($id_recipe)
    {
        $query = 'SELECT r.*, u.username, u.email FROM recipes r JOIN users u ON r.id_user = u.id_user WHERE id_recipe = :id_recipe';

        $dbMail = $this->db->fetchAssoc($query, [':id_recipe' => $id_recipe]);

        if(!empty($dbMail)){

            // Subject of confirmation email.
            $subject = 'Validation d\'une recette en attente';

            // Who should the confirmation email be from?
            $sender = 'J\'ai faim! <no-reply@myemail.co.uk>';

            $msg = $dbMail['username'] . " viens de créer une recette. Voici les détails: \r\n"
                . "- \r\n" . $dbMail['id_recipe']
                . "- \r\n" . $dbMail['title']
            ;

            @mail('reyesgregorie@gmail.com', $subject, $msg, 'L\'équipe de Fringale ! ');
        }
    }*/

    public function validateMail($id_recipe)
    {
        $query = 'SELECT r.*, u.username, u.email FROM recipes r JOIN users u ON r.id_user = u.id_user WHERE id_recipe = :id_recipe';

        $dbMail = $this->db->fetchAssoc($query, [':id_recipe' => $id_recipe]);

        if(!empty($dbMail)){

            // Subject of confirmation email.
            $subject = 'Validation de votre recette';

            // Who should the confirmation email be from?
            $sender = 'J\'ai faim! <no-reply@myemail.co.uk>';

            $msg = $dbMail['username'] . ",\n\nNous vous informons que votre recette est validée et sera en ligne dans les plus brefs des délais.
            <br />";

            @mail($dbMail['email'], $subject, $msg, 'From: ' . $sender);
        }
    }

    public function totalRecipes() {
        $query = "SELECT COUNT(id_recipe) FROM recipes";

        return $this->db->fetchColumn($query);
    }

    public function filtered(array $filters, $nbResult)
    {
        $recipe = 'SELECT * FROM recipes WHERE 1=1';


        if (isset($filters["star_ingredient"]) and $filters["star_ingredient"]) {
            $recipe .= " AND star_ingredient = '" . $filters["star_ingredient"] . "'";
        }
        if (isset($filters["difficulty"]) and $filters["difficulty"]) {
            $recipe .= " AND difficulty = " . $filters["difficulty"];
        }
        if (isset($filters["prep_time"]) and $filters["prep_time"]) {
            $recipe .= " AND prep_time BETWEEN " . $filters["prep_time"];
        }
        if (isset($filters["cook_time"]) and $filters["cook_time"]) {
            $recipe .= " AND cook_time BETWEEN " . $filters["cook_time"];
        }
        if (isset($filters["portion"]) and $filters["portion"]) {
            $recipe .= " AND portion BETWEEN " . $filters["portion"];
        }

        $recipe .= " AND status = 'validee'";

        if (!empty($nbResult)) {
            $page = isset($filters['page']) ? $filters['page'] : 1;
            $offset = ceil(($page - 1) * $nbResult);

            $recipe .= ' LIMIT ' . $nbResult . ' OFFSET ' . $offset;
        }

        $dbStarIngredient = $this->db->fetchAll($recipe);

        $topIngredient = [];

        foreach ($dbStarIngredient as $dbTop) {
            $recipe = $this->buildEntity($dbTop);

            $topIngredient[] = $recipe;
        }
        return $topIngredient;
    }

    public function lastRecipe($id_region)
    {
        $dbLastRecipe = $this->db->fetchAll('SELECT recipes.*, users.* FROM recipes LEFT JOIN regions ON recipes.id_region = regions.id_region LEFT JOIN users ON users.id_user = recipes.id_user LEFT JOIN rating ON recipes.id_recipe = rating.id_recipe WHERE regions.id_region = :id_region ORDER BY date_recipe DESC LIMIT 5 ',
            [
                ":id_region" => $id_region
            ]
        );
        return $dbLastRecipe;
    }

    public function countStarIngredient()
    {
        $dbCountStarIngredient = $this->db->fetchAll('SELECT count(star_ingredient) AS total, recipes.* FROM recipes GROUP BY star_ingredient ORDER BY count(star_ingredient) ');
        return $dbCountStarIngredient;
    }

    public function topAuthor()
    {
        $dbTopAuthor = $this->db->fetchAll('SELECT count(recipes.id_user) AS result, users.* FROM recipes JOIN users ON recipes.id_user = users.id_user GROUP BY recipes.id_user ORDER BY count(recipes.id_user) DESC LIMIT 5');

        return $dbTopAuthor;
    }

    public function topComment()
    {
        $dbTopComment = $this->db->fetchAll('SELECT count(comments.id_comment) AS topComment, recipes.* FROM comments JOIN recipes ON comments.id_recipe = recipes.id_recipe GROUP BY comments.id_recipe ORDER BY count(comments.id_recipe) DESC LIMIT 5');

        return $dbTopComment;
    }

    public function find($id_recipe)
    {
        $query = 'SELECT r.*, s.region_name FROM recipes r'
            . ' JOIN regions s ON r.id_region = s.id_region'
            . ' WHERE id_recipe = :id_recipe'
        ;

        $dbRecipe = $this->db->fetchAssoc($query,
            [
                ':id_recipe' => $id_recipe
            ]
        );

        if (!empty($dbRecipe)) {
            return $this->buildEntity($dbRecipe);
        }
    }


    public function top($id_region)
    {
        $query = 'SELECT DISTINCT avg(rate) AS toprate, recipes.*, users.* FROM recipes JOIN regions ON recipes.id_region = regions.id_region JOIN users ON users.id_user = recipes.id_user JOIN rating ON recipes.id_recipe = rating.id_recipe WHERE regions.id_region = :id_region GROUP BY recipes.id_recipe ORDER BY toprate DESC LIMIT 5 ';

        $dbTopRegion = $this->db->fetchAll($query,
            [
                ':id_region' => $id_region
            ]
        );

        return $dbTopRegion;
    }


    public function findById_user($id_user)
    {

        $dbRecipeUser = $this->db->fetchAll('SELECT * FROM recipes WHERE id_user = :id_user',
            [
                ":id_user" => $id_user
            ]
        );
        return $dbRecipeUser;
    }

    public function save(Recipe $recipe)
    {
        // Les données à enregistrer en BDD
        $data = [
            'title' => $recipe->getTitle(),
            'star_ingredient' => $recipe->getStar_ingredient(),
            'difficulty' => $recipe->getDifficulty(),
            'prep_time' => $recipe->getPrep_time(),
            'cook_time' => $recipe->getCook_time(),
            'portion' => $recipe->getPortion(),
            'ingredients' => $recipe->getIngredients(),
            'methods' => $recipe->getMethods(),
            'status'  => $recipe->getStatus(),
            'story' => $recipe->getStory(),
            'id_region' => $recipe->getId_region(),
            'picture_recipe' => $recipe->getPicture_recipe(),
            'id_user' => $this->app['user.manager']->getUser()->getId_user(),
            'date_recipe' => date("Y-m-d")
        ];

        // Appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data);

        // On défini l'id quand on est en insert (setId())
        if (empty($recipe->getId_recipe())) {
            $recipe->setId_recipe($this->db->lastInsertId());
        }
    }

    public function validRecipe(Recipe $recipe)
    {
        $data = [
            'status' => 'validee'
        ];

        $this->persist($data, ['id_recipe' => $recipe->getId_recipe()]);
    }

    public function delete (Recipe $recipe)
    {
        $this->db->delete(
            'recipes',
            ['id_recipe' => $recipe->getId_recipe()]
        );
    }


    private function buildEntity(array $data)
    {
        $recipe = new Recipe();

        $recipe->setId_recipe($data['id_recipe'])
            ->setTitle($data['title'])
            ->setId_region($data['id_region'])
            ->setStar_ingredient($data['star_ingredient'])
            ->setPrep_time($data['prep_time'])
            ->setCook_time($data['cook_time'])
            ->setPicture_recipe($data['picture_recipe'])
            ->setDifficulty($data['difficulty'])
            ->setPortion($data['portion'])
            ->setStatus($data['status'])
            ->setIngredients($data['ingredients'])
            ->setMethods($data['methods'])
            ->setId_user($data["id_user"])
            ->setStory($data['story'])
            ->setDate_recipe($data['date_recipe']);

        if (isset($data['region_name'])) {
            $recipe->setRegionName($data['region_name']);
        }

        if (isset($data['username'])) {
            $recipe->setUserName($data['username']);
        }

        return $recipe;
    }
}