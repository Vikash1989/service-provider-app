<?php namespace App\Models;

use CodeIgniter\Model;

class ServicesModel extends Model
{
	protected $table = 'services';
    protected $allowedFields = ['service_category_id', 'name'];
}