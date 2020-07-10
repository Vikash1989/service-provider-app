<?php namespace App\Controllers;

use App\Models\ServiceProvidersModel;

class Search extends BaseController
{
	private $data;
	public function __construct() {
		$request = \Config\Services::request();
		if ($request->isAJAX()) {
			$json_request_body = file_get_contents('php://input');
			$this->data = json_decode($json_request_body);
		} else {
			return redirect()->to(route_to('Home'));
		}
	}

	public function fetchAll() {
		$model = new ServiceProvidersModel();
		$serviceProviders = $model->where('is_approved', 2)->findAll();
		return $this->response->setJSON($serviceProviders);
	}

	public function fetchBySearchTerms() {
		$model = new ServiceProvidersModel();
    	$dataArray = [
    		'zipcode' => $this->data->zipcode,
    		'state' => $this->data->state,
    		'city' => $this->data->city,
    		'services' => $this->data->services,
    	];

    	if( !$dataArray['zipcode'] && !$dataArray['state'] && !$dataArray['city'] && !$dataArray['services'] ) {
    		// if each search term is blank - show all data
    		// we can change it to show error or No result found
    		// return null;
    		return $this->fetchAll();
    	}

    	// break $services string in to remove ',' or ', ' and create array
    	$servicesArray = [];
    	if($dataArray['services']) {
    		$formattedServicesString = str_replace([','], ' ', $dataArray['services']);
    		$formattedServicesString = preg_replace('/\s+/', ' ', $formattedServicesString);;
    		$servicesArray = explode(' ', $formattedServicesString);
    	}

    	// return json_encode($servicesArray);
    	$serviceProviders = [];
    	foreach ($dataArray as $key => $value) {
			if( $key !== 'services' ) {
				if($value !== '') {
					$tempResult = $model->where('is_approved', 2)->like('address', $value, 'both', NULL, TRUE)->findAll();
					foreach ($tempResult as $r) {
						if( !in_array( $r, $serviceProviders ) ) {
							$serviceProviders[] = $r;
						}
					}
				}
			} else {
				// for services array
				foreach ($servicesArray as $service) {
					$tempResult = $model->where('is_approved', 2)->like('services', $service, 'both', NULL, TRUE)->orWhere('is_approved', 2)->like('services_list', $service)->findAll();
					foreach ($tempResult as $r) {
						if( !in_array( $r, $serviceProviders ) ) {
							$serviceProviders[] = $r;
						}
					}
				}
			}
		}
    	return $this->response->setJSON($serviceProviders);
	}

	public function fetchByIds() {
		$model = new ServiceProvidersModel();
		$ids = $this->data->ids;
		if( count($ids) > 0 ) {
			$serviceProviders = $model->where('is_approved', 2)->whereIn('id', $ids)->findAll();
			return $this->response->setJSON($serviceProviders);
		}
	}
}