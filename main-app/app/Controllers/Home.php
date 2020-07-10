<?php namespace App\Controllers;

use App\Models\ServiceProvidersModel;

class Home extends BaseController
{
	public function index()
	{
		$data['title'] = 'Register';

		echo view('template/header', $data);
		echo view('home', $data);
		echo view('template/footer', $data);
	}

	public function process() {
		// If post request
		if( $this->request->getMethod() == 'post' ) {
			if( ! $this->validate([
				'name' => 'required',
				'email' => 'required|valid_email|is_unique[service-providers.email,id,{id}]',
				'company' => 'required',
				'phone' => 'required',
				'services' => 'required',
				'address' => 'required'
			]) ) {
				$validation = $this->validator;
				$errors = $validation->getErrors();
				return redirect()->back()->withInput()->with('errors', $errors);
			} else {
				// Data validated. Save in db
				$model = new ServiceProvidersModel();
				$model->save([
					'name' => $this->request->getVar('name'),
					'email' => $this->request->getVar('email'),
					'company' => $this->request->getVar('company'),
					'phone' => $this->request->getVar('phone'),
					'services' => $this->request->getVar('services'),
					'address' => $this->request->getVar('address'),
				]);

				// send email to admin
				$email = \Config\Services::email();
				// $email->initialize($config);

				$email->setFrom('helpdesk.llc20@gmail.com', 'Support');
				$email->setTo('vikash1989tiwari@gmail.com');
				$email->setSubject('New service provider interest received!');
				$emailContent = view('template/admin-notification');
				$email->setMessage($emailContent);

				if (! $email->send()) {
					// echo $email->printDebugger(['headers']);
					echo "Some error occurred. Please try again!";
				}

				// redirect to request-submitted page
				return redirect()->to('/request-submitted');
			}
		} else {
			return redirect()->to('/');
		}
	}

	public function submitted() {
		$data['title'] = 'Request Submitted';

		echo view('template/header', $data);
		echo view('request-submitted', $data);
		echo view('template/footer', $data);
	}

}
