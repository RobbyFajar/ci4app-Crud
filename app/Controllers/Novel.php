<?php

namespace App\Controllers;

use App\Models\NovelModel;

class Novel extends BaseController
{
    protected $novelModel;
    //menggunakan base OOP
    public function __construct()
    {
        $this->novelModel = new NovelModel();
    }
    public function index()
    {
        // $novel = $this->novelModel->findAll();

        $data = [
            'title' => 'Daftar Novel',
            'novel' => $this->novelModel->getNovel()
        ];
        // cara konek database tanpa model
        // $db = \config\Database::connect();
        // $novel = $db->query("SELECT * FROM novel");
        // foreach ($novel->getResultArray() as $row) {
        //     d($row);
        // }

        // $novelModel = new \App\Models\NovelModels();
        // $novelModel = new NovelModels(); diterapkan gini bisa cuman satu satu


        return view('novel/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Novel',
            'novel' => $this->novelModel->getNovel($slug)
        ];


        //kalo novel ga ada
        if (empty($data['novel'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('judul novel ' . $slug . 'Tidak Ditemukan');
        }

        return view('novel/detail', $data);
    }

    //----------------------------------------------------------------------------method create -----------------------------------------------------------------------------

    public function create()
    {
        //session(); karena di defaultkan di basecontrollers
        $data = [
            'title' => 'Form Tambah Data Novel',
            'validation' => \Config\Services::validation()
        ];

        return view('novel/create', $data);
    }

    public function save()
    {
        //cek validasi input
        if (!$this->validate([
            'judul' => [

                'rules' => 'required|is_unique[novel.judul]',
                'errors' => [
                    'required' => '{field} novel harus di isi',
                    'is_unique' => '{field} novel sudah terdaftar'

                ]

            ],
            'sampul' => [
                //uploaded[sampul]| upload di hapus karena menggunakan default
                'rules' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    //'uploaded' => 'Pilih Gambar Sampul terlebih dahulu',
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'file yang anda pilih bukan gambar',
                    'mime_in'  => 'file yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            //karena sudah ada di session $validation = \Config\Services::validation();
            //return redirect()->to('/novel/create')->withInput()->with('validation', $validation);
            return redirect()->to('/novel/create')->withInput();
        }


        //cara ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        //jika sampul tidak di upload menjadi default gambar
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.png';
        } else {
            //methodeuntuk generate random name
            $namaSampul = $fileSampul->getRandomName();
            //terus piundahkan file ke img / ke server
            $fileSampul->move('img');
            //ambil nama file utuk ke database
            //$namaSampul = $fileSampul->getName();
        }


        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->novelModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');

        return redirect()->to('/novel');
    }

    //----------------------------------------------------------------------------method delete -----------------------------------------------------------------------------

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $novel = $this->novelModel->find($id);

        //cek gambar apabila default

        if ($novel['sampul'] != 'default.png') {
            //hapusgambar kalo ingin di hapus dengan file didalam folder img
            unlink('img/' . $novel['sampul']);
        }

        $this->novelModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to('/novel');
    }


    //----------------------------------------------------------------------------method update -----------------------------------------------------------------------------
    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Novel',
            'validation' => \Config\Services::validation(),
            'novel' => $this->novelModel->getNovel($slug)
        ];

        return view('novel/edit', $data);
    }

    public function update($id)
    {
        //cek judul
        $novelLama = $this->novelModel->getNovel($this->request->getVar('slug'));
        if ($novelLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[novel.judul]';
        }

        if (!$this->validate([
            'judul' => [

                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} novel harus di isi',
                    'is_unique' => '{field} novel sudah terdaftar'

                ]

            ],
            'sampul' => [
                //uploaded[sampul]| upload di hapus karena menggunakan default
                'rules' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    //'uploaded' => 'Pilih Gambar Sampul terlebih dahulu',
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'file yang anda pilih bukan gambar',
                    'mime_in'  => 'file yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            //$validation = \Config\Services::validation();
            return redirect()->to('/novel/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        //cek gambar lama atau tidak
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            //random
            $namaSampul = $fileSampul->getRandomName();
            //terus piundahkan file ke img / ke server
            $fileSampul->move('img', $namaSampul);
            //hapus sampul lama
            unlink('img' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->novelModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data Berhasil Ubah');

        return redirect()->to('/novel');
    }
}
