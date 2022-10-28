<?php

namespace App\Controllers;

use App\Models\MemberModel;

class Member extends BaseController
{
    protected $memberModel;
    //menggunakan base OOP
    public function __construct()
    {
        $this->memberModel = new memberModel();
    }
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $member = $this->memberModel->search($keyword);
        } else {
            $member = $this->memberModel;
        }

        $currentPage = $this->request->getVar('page_member') ? $this->request->getVar('page_member') : 1;
        $data = [
            'title' => 'Daftar Member',
            // 'member' => $this->memberModel->findAll()
            'member' => $this->memberModel->paginate(10, 'member'),
            'pager' => $this->memberModel->pager,
            'currentPage' => $currentPage
        ];

        return view('member/index', $data);
    }
}
