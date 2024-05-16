<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        return view('web/home');
    }

    public function notonline()
    {
        return view('errors/html/mt');
    }

    public function new_home()
    {
        return view('web/new_home');
    }

    public function kegiatan()
    {
        return view('web/kegiatan', [
            'data' => $this->db->table('kegiatan')->get()->getResultArray()
        ]);
    }

    public function kegiatan_detail($id)
    {
        return view('web/kegiatan-detail');
    }
}
