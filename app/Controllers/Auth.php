<?php

namespace App\Controllers;

use App\Models\User;

class Auth extends BaseController
{
	public function login()
	{
		if (session()->get('is_login')) {
			return redirect()->to('/');
		}
		return view('Auth/Login');
	}

	public function register()
	{
		if (session()->get('is_login')) {
			return redirect()->to('/');
		}
		return view('Auth/Register');
	}

	public function checkLogin()
	{
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');
		$inputs = array(
			'username' => $username,
			'password' => $password
		);

		$validation = service('validation');
		$validation->setRules(
			[
				'username' => 'required|string|min_length[3]|is_not_unique[user.username]',
				'password' => 'required|string|min_length[4]'
			],
			customValidationErrorMessage()
		);

		if (!$validation->run($inputs)) {
			return redirectWithMessage(site_url('auth/login'), $validation->getErrors());
		}

		$userModel = new User();

		$user 		   = $userModel->where('username', $username)->first();
		$userPassword  = $user['password'];
		$passwordMatch = md5((string)$password) === $userPassword;
		if (!$passwordMatch) {
			return redirectWithMessage(site_url('auth/login'), WRONG_LOGIN_INFORMATION_MESSAGE);
		}

		$displayName = $user['firstname'] . ' ' .  $user['lastname'] === ' ' ? $user['username'] : $user['firstname'] . ' ' .  $user['lastname'];

		$sessionData = [
			'user_id'  => $user['id'],
			'name'     => $displayName,
			'type'	   => $user['type'],
			'is_login' => TRUE,
		];

		session()->set($sessionData);
		return redirect()->to('/');
	}

	public function checkRegister()
	{

		$validation = service('validation');
		$validation->setRules(
			[
				'username' 	  => 'required|string|min_length[3]|is_unique[users.username]',
				'password' 	  => 'required|string|min_length[4]',
				're_password' => 'required|string|min_length[4]|matches[password]',
				'email' 	  => 'required|string|is_unique[users.email]',
				'firstname'   => 'string',
				'lastname' 	  => 'string',
			],
			customValidationErrorMessage()
		);

		if (!$validation->run($this->request->getPost())) {
			return redirectWithMessage(site_url('auth/register'), $validation->getErrors());
		}

		$data = [
			'username'  => $this->request->getPost('username'),
			'password'  => md5((string)$this->request->getPost('password')),
			'email'	    => $this->request->getPost('email'),
			'firstname' => $this->request->getPost('firstname'),
			'lastname'  => $this->request->getPost('lastname'),
			'type' 		=> 'user'
		];

		$userModel = new User();
		$userModel->insert($data);

		return redirectWithMessage(site_url('auth/register'), 'success', 'success', FALSE);
	}


	/**
	 * Used to logout the user.
	 * 
	 */
	function logout()
	{
		session()->destroy();
		return redirect()->to('auth/login');
	}
}
