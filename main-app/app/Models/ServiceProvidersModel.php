<?php namespace App\Models;

use CodeIgniter\Model;

class ServiceProvidersModel extends Model
{
    protected $table = 'service-providers';
    protected $allowedFields = ['name', 'email', 'company', 'phone', 'address', 'services', 'services_list', 'comment', 'logo', 'is_approved', 'date_modified'];
}