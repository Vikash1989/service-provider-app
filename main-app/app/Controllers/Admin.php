<?php namespace App\Controllers;

use App\Models\ServiceProvidersModel;
use App\Models\AdminModel;

class Admin extends BaseController
{
	private $session;
	public function __construct() {
		$this->session = \Config\Services::session();
	}

	public function index() {
		// if already logged in redirect to dashboard
		// otherwise show login page
		if( !$this->session->has('logged_in') ) {
			$data['title'] = 'Login';
			echo view('admin/login', $data);
		} else {
			return redirect()->to(route_to('admin-dashboard'));
		}
	}

	public function auth() {
		if( $this->request->getMethod() == 'post' ) {
			if( ! $this->validate([
				'email' => 'required|valid_email',
				'password' => 'required',
			]) ) {
				$validation = $this->validator;
				$errors = $validation->getErrors();
				return redirect()->back()->withInput()->with('errors', $errors);
			} else {
				$email = $this->request->getVar('email');
				$password = md5($this->request->getVar('password'));
				$model = new AdminModel;
				$validate = $model->checkAdmin($email, $password);
				if($validate) {
					// if login details are correct create session
					$admin_data = [
						'name' => $validate['name'],
						'email' => $validate['email'],
						'logged_in' => TRUE,
					];
					// $session = \Config\Services::session();
					$this->session->set($admin_data);
					return redirect()->to(route_to('admin-dashboard'));
				} else {
					// if admin details are wrong redirect back with error message
					$errors = [];
					$errors['invalidDetails'] = 'Invalid email id or password';
					return redirect()->back()->withInput()->with('errors', $errors);
				}
			}
		} else {
			return redirect()->to( route_to('admin-login') );
		}
	}

	public function logout() {
		$this->session->destroy();
		return redirect()->to( route_to('admin-login') );
	}
}