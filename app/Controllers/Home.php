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
        return view('web/home', [
            'data' => $this->db->table('corousel')->get()->getResultArray()
        ]);
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
        return view('web/kegiatan-detail', [
            'data' => $this->db->table('kegiatan')->getWhere(['id_kegiatan' => $id])->getRowArray(),
            'kegiatan' => $this->db->table('kegiatan')->orderBy('id_kegiatan', 'RANDOM')->get(4)->getResultArray()
        ]);
    }
}