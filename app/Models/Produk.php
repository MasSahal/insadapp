<?php

namespace App\Models;

use CodeIgniter\Model;

class Produk extends Model
{
    protected $table      = 'produk';
    protected $primaryKey = 'id_produk';

    protected $returnType     = 'object';

    protected $allowedFields = [
        'nama',
        'harga',
        'status',
        'keterangan',
        'jumlah',
        'jenis',
        'tanggal_register',
        'kode_produk',
        'id_petugas',
        'gambar'
    ];

    public function getAll($id = false)
    {
        if ($id == false) {
            $this->db->table($this->table);
            $this->select('*');
            $this->orderBy('tanggal_register', 'ASC');
            return $this->get()->getResultObject();
        } else {
            $this->db->table($this->table);
            $this->select('*');
            $this->join('petugas', 'produk.id_petugas = petugas.id_petugas');
            $this->where($this->table . '.id_produk', $id);
            $this->orderBy('tanggal_register', 'ASC');
            return $this->get()->getResultObject();
        }
    }
}
