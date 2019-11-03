<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $userData = $this->m_data->getWhere("nip", $this->session->userdata("login")->nip);
        $userData = $this->m_data->getData("admin")->row();
        if ($userData->level !== "super_admin") {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data["aktif"]  = "petugas";
        return $this->loadView('petugas.pos.show-pos', $data);
    }

    public function tambah()
    {
        $data["aktif"]  = "petugas";
        return $this->loadView('petugas.pos.tambah-pos', $data);
    }
}
