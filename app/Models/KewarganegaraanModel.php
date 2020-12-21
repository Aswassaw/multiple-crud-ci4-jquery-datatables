<?php

namespace App\Models;

use CodeIgniter\Model;

class KewarganegaraanModel extends Model
{
    protected $table      = 'kewarganegaraan';
    protected $primaryKey = 'id_kewarganegaraan';
    protected $allowedFields = ['nama_kewarganegaraan'];
}
