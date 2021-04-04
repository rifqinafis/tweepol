<?php

namespace App\Models;

use CodeIgniter\Model;

class TweetModel extends Model
{
    protected $table = 'tweet';
    protected $useTimestamps = true;

    public function search($keyword)
    {
        return $this->table('tweet')->like('username', $keyword);
    }
}
