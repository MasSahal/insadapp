<?php

namespace App\Models;

use CodeIgniter\Model;

class Ruang extends Model
{
    protected $table      = 'ruang';
    protected $primaryKey = 'id_ruang';

    protected $returnType     = 'object';

    protected $allowedFields = ['nama_ruang', 'kode_ruang', 'keterangan'];
}
