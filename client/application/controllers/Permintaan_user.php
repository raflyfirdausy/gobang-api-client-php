<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_user extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data["title"]  = "Riwayat Permintaan User";
        $data["aktif"]  = "permintaan_user";
        
        return $this->loadView('permintaan-user.show', $data);
    }
}
