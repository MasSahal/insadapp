<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPenyewaan extends Model
{
    protected $table      = 'detail_penyewaan';
    protected $primaryKey = 'id_detail';

    protected $returnType     = 'object';

    protected $allowedFields = ['id_sewa', 'id_produk', 'nama_produk', 'qty', 'harga'];
}
