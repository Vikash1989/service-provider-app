<?php namespace App\Models;

use CodeIgniter\Model;

class DocumentsModel extends Model
{
	protected $table = 'documents';
    protected $allowedFields = ['service_provider_id', 'document'];
}