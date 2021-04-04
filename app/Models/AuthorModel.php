<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthorModel extends Model
{
    protected $table = 'akun';
    protected $useTimestamps = true;

    public function search($keyword)
    {
        return $this->table('akun')->like('username', $keyword)->orlike('nama', $keyword);
    }
}
