<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'member';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'alamat'];

    public function search($keyword)
    {
        $builder = $this->table('member');
        $builder->like('nama', $keyword)->orLike('alamat', $keyword);
        return $builder;
    }
}
