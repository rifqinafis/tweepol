<?php

namespace App\Controllers;

use App\Models\TweetModel;

class Tweet extends BaseController
{
    protected $tweetModel;

    public function __construct()
    {
        $this->tweetModel = new TweetModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $currentPage = $this->request->getVar('page_tweet') ? $this->request->getVar('page_tweet') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $tweet = $this->tweetModel->search($keyword);
            $totalresult = $db->query("SELECT * FROM tweet WHERE username LIKE '%$keyword%'");
        } else {
            $tweet = $this->tweetModel;
            $totalresult = $db->query("SELECT * FROM tweet");
        }

        $data = [
            'title' => 'Daftar Tweet',
            'tweet' => $tweet->paginate(10, 'tweet'),
            'pager' => $this->tweetModel->pager,
            'currentPage' => $currentPage,
            'totalresult' => $totalresult->getResultArray()
        ];

        return view('tweet/index', $data);
    }

    public function wordcloud()
    {
        $db = \Config\Database::connect();
        $wordcloud = $db->query("SELECT * FROM wordcloud ORDER BY freq DESC LIMIT 100");

        $data = [
            'title' => 'Word Cloud',
            'wordcloud' => $wordcloud->getResultArray()
        ];

        return view('tweet/wordcloud', $data);
    }

    public function bulan()
    {
        $db = \Config\Database::connect();
        $ttotal = $db->query("SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 1
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 2
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 3
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 4
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 5
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 6
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 7
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 8
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 9
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM `tweet` WHERE MONTH(created_at) = 10");

        $tlaki = $db->query("SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 1 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 2 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 3 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 4 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 5 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 6 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 7 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 8 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 9 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 10 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username");

        $tpuan = $db->query("SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 1 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 2 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 3 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 4 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 5 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 6 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 7 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 8 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 9 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS bulan FROM akun,tweet WHERE MONTH(created_at) = 10 AND gender = 'PEREMPUAN' AND akun.username = tweet.username");


        $data = [
            'title' => 'Grafik Tweet PerBulan',
            'ttotal' => $ttotal->getResultArray(),
            'tlaki' => $tlaki->getResultArray(),
            'tpuan' => $tpuan->getResultArray()
        ];

        return view('tweet/bulan', $data);
    }

    public function hari()
    {
        $db = \Config\Database::connect();
        $ttotal = $db->query("SELECT COUNT(full_text) AS hari FROM tweet WHERE DAYNAME(created_at) = 'Monday'
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM tweet WHERE DAYNAME(created_at) = 'Tuesday'
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM tweet WHERE DAYNAME(created_at) = 'Wednesday'
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM tweet WHERE DAYNAME(created_at) = 'Thursday'
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM tweet WHERE DAYNAME(created_at) = 'Friday'
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM tweet WHERE DAYNAME(created_at) = 'Saturday'
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM tweet WHERE DAYNAME(created_at) = 'Sunday'");

        $tlaki = $db->query("SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Monday' AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Tuesday' AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Wednesday' AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Thursday' AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Friday' AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Saturday' AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Sunday' AND gender = 'LAKI-LAKI' AND akun.username = tweet.username");

        $tpuan = $db->query("SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Monday' AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Tuesday' AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Wednesday' AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Thursday' AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Friday' AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Saturday' AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS hari FROM akun,tweet WHERE DAYNAME(created_at) = 'Sunday' AND gender = 'PEREMPUAN' AND akun.username = tweet.username");

        $data = [
            'title' => 'Grafik Tweet PerHari',
            'ttotal' => $ttotal->getResultArray(),
            'tlaki' => $tlaki->getResultArray(),
            'tpuan' => $tpuan->getResultArray()
        ];

        return view('tweet/hari', $data);
    }

    public function jam()
    {
        $db = \Config\Database::connect();
        $ttotal = $db->query("SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 0
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 1
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 2
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 3
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 4
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 5
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 6
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 7
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 8
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 9
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 10
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 11
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 12
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 13
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 14
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 15
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 16
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 17
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 18
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 19
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 20
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 21
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 22
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM tweet WHERE HOUR(created_at) = 23");

        $tlaki = $db->query("SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 0 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 1 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL 
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 2 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 3 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 4 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 5 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 6 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 7 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 8 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 9 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 10 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 11 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 12 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 13 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 14 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 15 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 16 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 17 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 18 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 19 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 20 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 21 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 22 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 23 AND gender = 'LAKI-LAKI' AND akun.username = tweet.username");

        $tpuan = $db->query("SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 0 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 1 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 2 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 3 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 4 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 5 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 6 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 7 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 8 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 9 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 10 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 11 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 12 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 13 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 14 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 15 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 16 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 17 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 18 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 19 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 20 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 21 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 22 AND gender = 'PEREMPUAN' AND akun.username = tweet.username
        UNION ALL
        SELECT COUNT(full_text) AS jam FROM akun,tweet WHERE HOUR(created_at) = 23 AND gender = 'PEREMPUAN' AND akun.username = tweet.username");



        $data = [
            'title' => 'Grafik Tweet PerJam',
            'ttotal' => $ttotal->getResultArray(),
            'tlaki' => $tlaki->getResultArray(),
            'tpuan' => $tpuan->getResultArray()
        ];

        return view('tweet/jam', $data);
    }
}
