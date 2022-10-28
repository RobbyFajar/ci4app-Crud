<?php

namespace App\Models;

use CodeIgniter\Model;

class NovelModel extends Model
{
    protected $table = 'novel';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'slug', 'penulis', 'penerbit', 'sampul'];


    public function getNovel($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
