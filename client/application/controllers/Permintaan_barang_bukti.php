<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_barang_bukti extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        
        $data_permintaan_bb     = $this->m_data->getData("permintaan_bb")->result();

        $data["data_permintaan_bb"] = $data_permintaan_bb;
        $data["title"]              = "Permintaan Barang Bukti";
        $data["aktif"]              = "permintaan_barang_bukti";
        return $this->loadView('permintaan-barang-bukti.show', $data);
    }
}