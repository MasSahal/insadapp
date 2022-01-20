<?php

namespace App\Models;

use CodeIgniter\Model;

class Jenis extends Model
{
    protected $table      = 'jenis';
    protected $primaryKey = 'id_jenis';

    protected $returnType     = 'object';

    protected $allowedFields = ['nama_jenis', 'kode_jenis', 'keterangan'];
}
