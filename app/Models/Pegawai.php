<?php

namespace App\Models;

use CodeIgniter\Model;

class Pegawai extends Model
{
    protected $table      = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $returnType     = 'object';

    protected $allowedFields = ['nama_pegawai', 'nip', 'alamat', 'password'];
}
