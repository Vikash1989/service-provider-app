<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $allowedFields = ['name', 'email', 'password'];

    public function checkAdmin($email, $password) {
    	$admin = $this->where('email', $email)->where('password', $password)->first();
    	return $admin;
    }
}