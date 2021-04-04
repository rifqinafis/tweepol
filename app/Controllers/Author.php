<?php

namespace App\Controllers;

use App\Models\AuthorModel;

class Author extends BaseController
{
    protected $authorModel;

    public function __construct()
    {
        $this->authorModel = new AuthorModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $currentPage = $this->request->getVar('page_akun') ? $this->request->getVar('page_akun') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $author = $this->authorModel->search($keyword);
            $totalresult = $db->query("SELECT * FROM akun WHERE username LIKE '%$keyword%' OR nama LIKE '%$keyword%'");
        } else {
            $author = $this->authorModel;
            $totalresult = $db->query("SELECT * FROM akun");
        }

        $data = [
            'title' => 'Daftar Authors',
            'author' => $author->paginate(7, 'akun'),
            'pager' => $this->authorModel->pager,
            'currentPage' => $currentPage,
            'totalresult' => $totalresult->getResultArray()
        ];

        return view('author/index', $data);
    }

    public function grafik()
    {
        $db = \Config\Database::connect();
        $ttotal = $db->query("SELECT COUNT(username) AS usia FROM akun WHERE usia BETWEEN 21 AND 30
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE usia BETWEEN 31 AND 40
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE usia BETWEEN 41 AND 50
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE usia BETWEEN 51 AND 60
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE usia BETWEEN 61 AND 70
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE usia BETWEEN 71 AND 80");

        $tlaki = $db->query("SELECT COUNT(id_akun) AS usia FROM akun WHERE gender = 'LAKI-LAKI' AND usia BETWEEN 21 AND 30
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'LAKI-LAKI' AND usia BETWEEN 31 AND 40
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'LAKI-LAKI' AND usia BETWEEN 41 AND 50
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'LAKI-LAKI' AND usia BETWEEN 51 AND 60
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'LAKI-LAKI' AND usia BETWEEN 61 AND 70
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'LAKI-LAKI' AND usia BETWEEN 71 AND 80");

        $tpuan = $db->query("SELECT COUNT(username) AS usia FROM akun WHERE gender = 'PEREMPUAN' AND usia BETWEEN 21 AND 30
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'PEREMPUAN' AND usia BETWEEN 31 AND 40
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'PEREMPUAN' AND usia BETWEEN 41 AND 50
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'PEREMPUAN' AND usia BETWEEN 51 AND 60
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'PEREMPUAN' AND usia BETWEEN 61 AND 70
        UNION ALL
        SELECT COUNT(username) AS usia FROM akun WHERE gender = 'PEREMPUAN' AND usia BETWEEN 71 AND 80");

        $data = [
            'title' => 'Grafik Tweet PerBulan',
            'ttotal' => $ttotal->getResultArray(),
            'tlaki' => $tlaki->getResultArray(),
            'tpuan' => $tpuan->getResultArray()
        ];

        return view('author/grafik', $data);
    }
}
