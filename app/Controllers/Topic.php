<?php

namespace App\Controllers;

class Topic extends BaseController
{
    public function topic0()
    {
        $db = \Config\Database::connect();
        $topik0 = $db->query("SELECT * FROM toptopik WHERE id_topik = 0");
        $atopik0 = $db->query("SELECT * FROM authortopic0");

        $data = [
            'title' => 'Topik 0',
            'topik' => $topik0->getResultArray(),
            'atopik' => $atopik0->getResultArray()
        ];

        return view('topic/topic0', $data);
    }

    public function topic1()
    {
        $db = \Config\Database::connect();
        $topik1 = $db->query("SELECT * FROM toptopik WHERE id_topik = 1");
        $atopik1 = $db->query("SELECT * FROM authortopic1");

        $data = [
            'title' => 'Topik 1',
            'topik' => $topik1->getResultArray(),
            'atopik' => $atopik1->getResultArray()
        ];
        return view('topic/topic1', $data);
    }

    public function topic2()
    {
        $db = \Config\Database::connect();
        $topik2 = $db->query("SELECT * FROM toptopik WHERE id_topik = 2");
        $atopik2 = $db->query("SELECT * FROM authortopic2");

        $data = [
            'title' => 'Topik 2',
            'topik' => $topik2->getResultArray(),
            'atopik' => $atopik2->getResultArray()
        ];
        return view('topic/topic2', $data);
    }
}
