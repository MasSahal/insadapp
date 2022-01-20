<?php

namespace App\Models;

use CodeIgniter\Model;

class Petugas extends Model
{
    protected $table      = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $returnType     = 'object';

    protected $allowedFields = ['username', 'password', 'nama_petugas', 'id_level'];

    public function getDataWithLevel()
    {
        $this->db->table($this->table);
        $this->select('*');
        $this->join('level', 'petugas.id_level = level.id_level');
        return $this->get()->getResultObject();
    }

    public function countDataWithLevel()
    {
        $this->db->table($this->table);
        $this->select('*');
        $this->join('level', 'petugas.id_level = level.id_level');
        return $this->get()->getResultObject();
    }

    public function getAdmin($id = false)
    {
        if ($id == false) {
            $this->db->table($this->table);
            $this->select('*');
            $this->join('level', 'petugas.id_level = level.id_level');
            $this->where('level.nama_level', 'admin');
            return $this->get()->getResultObject();
        } else {
            $this->db->table($this->table);
            $this->select('*');
            $this->join('level', 'petugas.id_level = level.id_level');
            $this->where($this->table . '.id_petugas', $id);
            return $this->get()->getResultObject();
        }
    }

    public function getOperator($id = false)
    {
        if ($id == false) {
            $this->db->table($this->table);
            $this->select('*');
            $this->join('level', 'petugas.id_level = level.id_level');
            $this->where('level.nama_level', 'operator');
            return $this->get()->getResultObject();
        } else {
            $this->db->table($this->table);
            $this->select('*');
            $this->join('level', 'petugas.id_level = level.id_level');
            $this->where($this->table . '.id_petugas', $id);
            return $this->get()->getResultObject();
        }
    }

    public function getPegawai($id = false)
    {
        if ($id == false) {
            $this->db->table($this->table);
            $this->select('*');
            $this->join('level', 'petugas.id_level = level.id_level');
            $this->where('level.nama_level', 'pegawai');
            return $this->get()->getResultObject();
        } else {
            $this->db->table($this->table);
            $this->select('*');
            $this->join('level', 'petugas.id_level = level.id_level');
            $this->where($this->table . '.id_petugas', $id);
            return $this->get()->getResultObject();
        }
    }
}
