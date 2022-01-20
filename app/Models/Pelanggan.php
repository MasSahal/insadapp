<?php

namespace App\Models;

use CodeIgniter\Model;

class Pelanggan extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'pelanggan';
	protected $primaryKey           = 'id_pelanggan';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['id_pelanggan', 'nama', 'no_ktp', 'telepon', 'email', 'password', 'alamat'];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	public function getAll($id = false)
	{
		if ($id == false) {
			$this->db->table($this->table);
			$this->select('*');
			return $this->get()->getResultObject();
		} else {
			$this->db->table($this->table);
			$this->select('*');
			$this->where($this->table . '.id_pelanggan', $id);
			return $this->get()->getResultObject();
		}
	}
}
