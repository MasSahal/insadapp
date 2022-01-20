<?php

namespace App\Models;

use CodeIgniter\Model;

class Penyewaan extends Model
{
    protected $table      = 'penyewaan';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $allowedFields = ['id_penyewaan', 'tanggal_penyewaan', 'id_pelanggan', 'jatuh_tempo', 'tanggal_kembali', 'status_penyewaan', 'id_pegawai'];

    public function getPenyewaan($id = false)
    {
        if ($id == false) {
            $this->db->table($this->table);
            $this->select('*');
            // $this->join('pegawai', 'penyewaan.id_pegawai = pegawai.id_pegawai');
            // $this->join('detail_sewa', 'penyewaan.id_penyewaan = detail_sewa.id_penyewaan');
            $this->join('pelanggan', 'penyewaan.id_pelanggan = pelanggan.id_pelanggan');
            return $this->get()->getResultObject();
        } else {
            $this->db->table($this->table);
            $this->select('*');
            $this->join('pelanggan', 'penyewaan.id_pelanggan = pelanggan.id_pelanggan');
            $this->where($this->table . '.id_penyewaan', $id);
            return $this->get()->getResultObject();
        }
    }

    public function kembalikanStok($id_penyewan, $data)
    {
        return $this->db->table($this->table)
            ->where('id_penyewaan', $id_penyewan)
            ->update($data);
    }
}
