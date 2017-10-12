<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 11/08/2017
 * Time: 14:37
 */

namespace Entity;


class Comment
{
    /**
     * @var
     */
    private $id_comment;

    /**
     * @var
     */
    private $id_user;

    /**
     * @var
     */
    private $id_recipe;

    /**
     * @var
     */
    private $content;

    /**
     * @var User
     */
    private $user;

    /**
     *
     * @var
     */
    private $comment_date;

    /**
     * @var
     */
    private $comment;

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment_date()
    {
        return $this->comment_date;
    }

    /**
     * @param $comment_date
     * @return $this
     */
    public function setComment_date($comment_date)
    {
        $this->comment_date = $comment_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId_comment()
    {
        return $this->id_comment;
    }

    /**
     * @param mixed $id_comment
     * @return Comment
     */
    public function setId_comment($id_comment)
    {
        $this->id_comment = $id_comment;
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
     * @return Comment
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
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
     * @return Comment
     */
    public function setId_recipe($id_recipe)
    {
        $this->id_recipe = $id_recipe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Comment
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /*************************************** USERNAME *******************************/

    private $userName;

    public function setUserName($username)
    {
        $this->userName = $username;

        return $this;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    /*************************************** RECIPE NAME *******************************/

    private $recipeName;

    /**
     * @param mixed $username
     *
     * @return self
     */
    public function setRecipeName($title)
    {
        $this->recipeName = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecipeName()
    {
        return $this->recipeName;

    }


}