<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 14/08/2017
 * Time: 16:02
 */

namespace Entity;


class Rating
{
    /**
     * @var
     */
    private $id_rate;

    /**
     * @var
     */
    private $id_recipe;

    /**
     * @var
     */
    private $id_user;

    /**
     * @var
     */
    private $rate;

    /**
     * @return mixed
     */
    public function getId_rate()
    {
        return $this->id_rate;
    }

    /**
     * @param mixed $id_rate
     * @return Rating
     */
    public function setId_rate($id_rate)
    {
        $this->id_rate = $id_rate;
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
     * @return Rating
     */
    public function setId_recipe($id_recipe)
    {
        $this->id_recipe = $id_recipe;
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
     * @param mixed $id_user
     * @return Rating
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     * @return Rating
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
        return $this;
    }


}