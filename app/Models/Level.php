<?php

namespace App\Models;

use CodeIgniter\Model;

class Level extends Model
{
    protected $table      = 'level';
    protected $primaryKey = 'id_level';

    protected $returnType     = 'object';

    protected $allowedFields = ['nama_level'];
}
