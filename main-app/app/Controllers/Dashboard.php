<?php namespace App\Controllers;

use App\Models\ServiceProvidersModel;
use App\Models\AdminModel;
use App\Models\DocumentsModel;
use App\Models\ServicesModel;

class Dashboard extends BaseController
{
	private $session;
	public function __construct() {
		$this->session = \Config\Services::session();
		$this->admin_session_validator();
	}

	private function admin_session_validator() {
		// $session = \Config\Services::session();
		if( !$this->session->has('logged_in') ){
			header('Location: '.route_to('admin-login'));
			exit();
		}
	}

	public function index() {
		$model = new ServiceProvidersModel();
		$title = 'Dashboard';
		$serviceProviders = $model->orderBy('date_added', 'DESC')->findAll();
		$pager = \Config\Services::pager();
		$data = [ 
			'serviceProviders' => $serviceProviders, 
			'title' => $title,
			// 'pager' => $model->pager 
		];
		// var_dump($serviceProviders);
		echo view('admin/template/header', $data);
		echo view('admin/dashboard', $data);
		echo view('admin/template/footer', $data);
	}

	public function user($id) {
		$model = new ServiceProvidersModel();
		$documentsModel = new DocumentsModel();
		$servicesModel = new ServicesModel();
		$serviceProvider = $model->find($id);
		$providerDocuments = $documentsModel->where('service_provider_id', $id)->findAll();
		$services = $servicesModel->findAll();
		if( $serviceProvider ) {
			$data = [
				'title' => 'User',
				'serviceprovider' => $serviceProvider,
				'providerDocuments' => $providerDocuments,
				'services' => $services
			];
			echo view('admin/template/header', $data);
			echo view('admin/user', $data);
			echo view('admin/template/footer', $data);
		} else {
			return redirect()->to(route_to('admin-dashboard'));
		}
	}

	public function edit($id) {
		$model = new ServiceProvidersModel();
		$title = 'Edit';
		$serviceProvider = $model->find($id);
		$pager = \Config\Services::pager();
		$data = [ 
			'serviceprovider' => $serviceProvider, 
			'title' => $title,
		];
		echo view('admin/template/header', $data);
		echo view('admin/edit', $data);
		echo view('admin/template/footer', $data);
	}

	public function updateUsersInfo($id) {
		if( $this->request->getMethod() == 'post' ) {
			if( ! $this->validate([
				'name' => 'required',
				'email' => 'required|valid_email',
				'company' => 'required',
				'phone' => 'required',
				'services' => 'required',
				'address' => 'required'
			]) ) {
				$validation = $this->validator;
				$errors = $validation->getErrors();
				return redirect()->back()->withInput()->with('errors', $errors);
			} else {
				// update details
				$model = new ServiceProvidersModel();
				$dataToUpdate = [
					'name' => $this->request->getVar('name'),
					'email' => $this->request->getVar('email'),
					'company' => $this->request->getVar('company'),
					'phone' => $this->request->getVar('phone'),
					'services' => $this->request->getVar('services'),
					'address' => $this->request->getVar('address')
				];
				$model->update($id, $dataToUpdate);
				return redirect()->to(route_to('view-user', $id))->with('success_msg', 'Personal Information Updated');
			}
		}
	}

	public function reject($id) {
		$model = new ServiceProvidersModel();
		$serviceProvider = $model->find($id);
		if( $serviceProvider ) {
			$name = $serviceProvider['name'];
			$emailID = $serviceProvider['email'];

			$dataToUpdate = [
				'is_approved' => 0,
				'date_modified' => date('Y-m-d H:i:s')
			];

			$model->update($id, $dataToUpdate);
			// send email to member
			$email = \Config\Services::email();
			$email->setFrom('helpdesk.llc20@gmail.com', 'Support');
			$email->setTo($emailID);
			$email->setSubject('Sorry! Your application got rejected');
			$emailContent = view('admin/template/reject-email', ['name' => $name]);
			$email->setMessage($emailContent);

			if (! $email->send()) {
				// echo $email->printDebugger(['headers']);
				echo "Some error occurred. Please try again!";
			}

			return redirect()->back()->with('success_msg', 'Application Rejected');
		} else {
			echo 'Something went wrong. Please try again';
		}
	}

	public function approve($id) {
		$model = new ServiceProvidersModel();
		$serviceProvider = $model->find($id);
		if( $serviceProvider ) {
			$name = $serviceProvider['name'];
			$emailID = $serviceProvider['email'];

			$dataToUpdate = [
				'is_approved' => 2,
				'date_modified' => date('Y-m-d H:i:s')
			];

			$model->update($id, $dataToUpdate);
			// send email to the member
			$email = \Config\Services::email();
			$email->setFrom('helpdesk.llc20@gmail.com', 'Support');
			$email->setTo($emailID);
			$email->setSubject('Congrats! Your application got approved');
			$emailContent = view('admin/template/approve-email', ['name' => $name]);
			$email->setMessage($emailContent);

			if (! $email->send()) {
				// echo $email->printDebugger(['headers']);
				echo "Some error occurred. Please try again!";
			}

			return redirect()->back()->with('success_msg', 'Application Approved');
		} else {
			echo 'Something went wrong. Please try again';
		}
	}

	public function delete($id) {
		$model = new ServiceProvidersModel();
		$serviceProvider = $model->find($id);
		if( $serviceProvider ) {
			$model->delete($id);
			return redirect()->to(route_to('admin-dashboard'))->with('success_msg', 'One Application Deleted');;
		} else {
			echo 'Something went wrong. Please try again';
		}
	}

	public function processAdditionalInformation($id) {
		// If post request
		if( $this->request->getMethod() == 'post' ) {
			if( ! $this->validate([
				'logo' => [
					'rules' => [
						'is_image[logo]',
						'max_size[logo, 4096]'
					],
					'errors' => [
						'is_image' => 'Logo file type is not correct. It should be an image file',
						'max_size' => 'Logo size can\'t exceed 4mb.'
					]
				],
			]) ) {
				$validation = $this->validator;
				$errors = $validation->getErrors();
				return redirect()->back()->withInput()->with('errors', $errors);
			} else {
				// Update in db
				$comment = $this->request->getVar('comment');
				if( $this->request->getVar('services_list') ) {
					$services_list = serialize($this->request->getVar('services_list'));
				} else {
					$services_list = null;
				}
				// print_r($services_list);
				// exit();
				$logo = $this->request->getFile('logo');

				$allFiles = $this->request->getFiles();
				
				$model = new ServiceProvidersModel();
				$serviceProvider = $model->find($id);

				if( $serviceProvider ) {
					$dataToUpdate['services_list'] = $services_list;
					$dataToUpdate['comment'] = $comment;
					if($logo->isValid() && ! $logo->hasMoved()) {
						$logoName = $logo->getRandomName();
						// $path = $this->request->getFile('logo')->store();
						$dataToUpdate['logo'] = $logoName;
						$logo->move('./uploads/images/', $logoName);
					}
					// update service provider table with comment and logo file
					$model->update($id, $dataToUpdate);

					// add new documents to its table
					foreach ($allFiles['documents'] as $document) {
						$documentsModel = new DocumentsModel();
						$documentToAdd = [];
						// $document = $this->request->getFile('documents.' . $index);
						if($document->isValid() && ! $document->hasMoved()) {
							$documentToAdd['service_provider_id'] = $id;
							$documentName = $document->getRandomName();
							$documentToAdd['document'] = $documentName;
							$document->move('./uploads/documents/', $documentName);
							// save to documents table
							$documentsModel->save($documentToAdd);
						}
					}

					return redirect()->back()->with('success_msg', 'Additional Details Updated');
				} else {
					echo 'Something went wrong. Please try again';
				}
			}
		}
	}

	public function deleteDocument($id) {
		$model = new DocumentsModel();
		$document = $model->find($id);
		if( $document ) {
			$model->delete($id);
			return redirect()->back()->with('success_msg', 'File Deleted');;
		} else {
			echo 'Something went wrong. Please try again';
		}
	}

	public function services() {
		$model = new ServicesModel();
		$services = $model->orderBy('id', 'DESC')->findAll();
		$data = [
			'title' => 'Services',
			'services' => $services
		];

		echo view('admin/template/header', $data);
		echo view('admin/services', $data);
		echo view('admin/template/footer', $data);
	}

	public function deleteService($id) {
		// to delete a service first delete it from the services_list column from
		// all service providers table
		$model = new ServicesModel();
		$service = $model->find($id);
		if($service) {
			$serviceName = $service['name'];
			$serviceProviderModel = new ServiceProvidersModel();
			// find all services providers having this service in services_list column
			$serviceProviders = $serviceProviderModel->like('services_list', $serviceName)->findAll();

			foreach ($serviceProviders as $serviceProvider) {
				if( $serviceProvider['services_list'] ) {
					$services_list = unserialize($serviceProvider['services_list']);
					// find the key from where service needs to be removed
					$key = array_search($serviceName, $services_list);
					// remove that service from the array
					array_splice($services_list, $key, 1);
					// serialize services_list array back
					$updatedServices_list = serialize($services_list);
					// update array back into services_list column
					$serviceProviderModel->update($serviceProvider['id'], ['services_list' => $updatedServices_list]);
				}
			}
			// delete services table
			$model->delete($id);
			return redirect()->back()->with('success_msg', 'Service Deleted');
		} else {
			echo 'Something went wrong. Please try again';
		}
	}

	public function addNewService() {
		if( $this->request->getMethod() == 'post' ) {
			if( ! $this->validate([
				'name' => [
					'rules' => [
						'required',
						'is_unique[services.name,id,{id}]'
					],
					'errors' => [
						'required' => 'Service title is required',
						'is_unique' => 'This service title is already added'
					]
				]
			]) ) {
				$validation = $this->validator;
				$errors = $validation->getErrors();
				return redirect()->back()->withInput()->with('errors', $errors);
			} else {
				// Add in services table
				$model = new ServicesModel();
				$model->save([
					'name' => $this->request->getVar('name')
				]);
				return redirect()->back()->with('success_msg', 'Service added successfully');
			}
		}
	}
}