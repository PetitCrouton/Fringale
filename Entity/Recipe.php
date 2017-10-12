<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 10/08/2017
 * Time: 10:06
 */

namespace Entity;


class Recipe
{
    /**
     * @var
     */
    private $id_recipe;

    /**
     * @var
     */
    private $id_region;

    /**
     * @var
     */
    private $id_user;

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $star_ingredient;

    /**
     * @var
     */
    private $difficulty;

    /**
     * @var
     */
    private $prep_time;

    /**
     * @var
     */
    private $cook_time;

    /**
     * @var
     */
    private $portion;

    /**
     * @var
     */
    private $ingredients;

    /**
     * @var
     */
    private $methods;

    /**
     * @var
     */
    private $story;

    /**
     * @var
     */
    private $status;

    /**
     * @var
     */
    private $picture_recipe;

    /**
     * @var
     */
    private $date_recipe;

    /**
     * @return mixed
     */
    public function getDate_recipe()
    {
        return $this->date_recipe;
    }

    /**
     * @param mixed $date_recipe
     * @return Recipe
     */
    public function setDate_recipe($date_recipe)
    {
        $this->date_recipe = $date_recipe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId_recipe()
    {
        return $this->id_recipe;
    }

    /**
     * @param mixed $id_recipe
     * @return Recipe
     */
    public function setId_recipe($id_recipe)
    {
        $this->id_recipe = $id_recipe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId_region()
    {
        return $this->id_region;
    }


    /**
     * @param Region $id_region
     * @return $this
     */
    public function setId_region($id_region)
    {
        $this->id_region = $id_region;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId_user()
    {
        return $this->id_user;
    }


    /**
     * @param User $id_user
     * @return $this
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Recipe
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStar_ingredient()
    {
        return $this->star_ingredient;
    }

    /**
     * @param mixed $star_ingredient
     * @return Recipe
     */
    public function setStar_ingredient($star_ingredient)
    {
        $this->star_ingredient = $star_ingredient;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param mixed $difficulty
     * @return Recipe
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrep_time()
    {
        return $this->prep_time;
    }

    /**
     * @param mixed $prep_time
     * @return Recipe
     */
    public function setPrep_time($prep_time)
    {
        $this->prep_time = $prep_time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCook_time()
    {
        return $this->cook_time;
    }

    /**
     * @param mixed $cook_time
     * @return Recipe
     */
    public function setCook_time($cook_time)
    {
        $this->cook_time = $cook_time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPortion()
    {
        return $this->portion;
    }

    /**
     * @param mixed $portion
     * @return Recipe
     */
    public function setPortion($portion)
    {
        $this->portion = $portion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param mixed $ingredients
     * @return Recipe
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param mixed $methods
     * @return Recipe
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * @param mixed $story
     * @return Recipe
     */
    public function setStory($story)
    {
        $this->story = $story;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Recipe
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPicture_recipe()
    {
        return $this->picture_recipe;
    }

    /**
     * @param mixed $picture_recipe
     * @return Recipe
     */
    public function setPicture_recipe($picture_recipe)
    {
        $this->picture_recipe = $picture_recipe;
        return $this;
    }

    /*************************************** REGION NAME *******************************/

    private $regionName;

    /**
     * @param mixed $region_name
     *
     * @return self
     */
    public function setRegionName($region_name)
    {
        $this->regionName = $region_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegionName()
    {
        return $this->regionName;

    }

    /*************************************** USERNAME *******************************/

    private $userName;

    /**
     * @param mixed $username
     *
     * @return self
     */
    public function setUserName($username)
    {
        $this->userName = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;

    }
}