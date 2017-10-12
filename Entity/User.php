<?php

namespace Entity;

class User
{
	private $id_user;

	private $lastname;

	private $firstname;

	private $email;

	private $username;

	private $civility;

	private $id_region;

	private $user_picture;

	private $status;

    private $password;

    /**
     * @return mixed
     */
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     *
     * @return self
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * @param mixed $civility
     *
     * @return self
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

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
     * @param mixed $id_region
     *
     * @return self
     */
    public function setId_region($id_region)
    {
        $this->id_region = $id_region;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser_picture()
    {
        return $this->user_picture;
    }

    /**
     * @param mixed $picture_user
     *
     * @return self
     */
    public function setUser_picture($user_picture)
    {
        $this->user_picture = $user_picture;

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
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
    
    /*
    @return bool
    */
    public function isAdmin()
    {
    	return $this->status == 'admin';
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

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

    public function getGravatarHash()
    {
        return hash('md5',strtolower($this->username));
    }
}