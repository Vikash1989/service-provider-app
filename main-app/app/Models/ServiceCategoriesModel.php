<?php namespace App\Models;

use CodeIgniter\Model;

class ServiceCategoriesModel extends Model
{
	protected $table = 'service-categories';
    protected $allowedFields = ['service_category'];
}