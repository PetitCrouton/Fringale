<?php

namespace Service;

use Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

class UserManager
{
	/*
	@var Session
	 */
	private $session;

	/*
	@param Session $session
	 */
	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	public function encodePassword($plainPassword)
	{
		return password_hash($plainPassword, PASSWORD_BCRYPT);
	}

	/*
	@param string $plainPassword
	@param string $encodedPassword
	@return bool
	 */
	public function verifyPassword($plainPassword, $encodedPassword)
	{
		return password_verify($plainPassword, $encodedPassword);
	}

	/*
	@param User $user
	 */
	public function login(User $user)
	{
		// $_SESSION['user'] = $user;
		$this->session->set('user', $user);
	}

	public function logout()
	{
		// unset($_SESSION['user']);
		$this->session->remove('user');
	}

	/*
	@return User|null
	 */
	public function getUser()
	{
		return $this->session->get('user');
	}

	/*
	@return string
	 */
	public function getUsername()
	{
		if($this->session->has('user')){
			return $this->session->get('user')->getUsername();
		}
		return '';
	}

    public function getUserId()
    {
        if($this->session->has('user')){
            return $this->session->get('user')->getId_user();
        }
        return null;
    }

    public function getGravatar()
    {
        return hash("md5",strtolower($this->session->get('user')->getUsername()));
    }

	/*
	@return bool
	 */
	public function isAdmin()
	{
		return $this->session->has('user') && $this->session->get('user')->isAdmin();
	}
}
