<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    private $userData;
    public function __construct()
    {
        parent::__construct();
        $this->userData = $this->m_data->getWhere("user_id", $this->session->userdata("login")->user_id);
        $this->userData = $this->m_data->getData("admin")->row();
    }

    public function index()
    {                
        $totalDataTilang        = $this->m_data->getData("daftar_terpidana")->num_rows();
        $totalPermintaanUser    = $this->m_data->getData("permintaan_user")->num_rows();

        $totalPermintaanBB      = $this->m_data->select("sum(total_permintaan) as total");
        $totalPermintaanBB      = $this->m_data->getData("permintaan_bb")->row();        
        
        $permintaanBBAktif      = $this->m_data->select("sum(total_permintaan) as total");
        $permintaanBBAktif      = $this->m_data->getWhere("acc_kejaksaan", 0);
        $permintaanBBAktif      = $this->m_data->getData("permintaan_bb")->row();        

        $data["aktif"]                  = "dashboard";
        $data["totalDataTilang"]        = $totalDataTilang;
        $data["totalPermintaanUser"]    = $totalPermintaanUser;
        $data["totalPermintaanBB"]      = $totalPermintaanBB->total == null ? "0" : $totalPermintaanBB->total;
        $data["permintaanBBAktif"]      = $permintaanBBAktif->total == null ? "0" : $permintaanBBAktif->total;

        if($this->userData->level == "pos"){
            redirect(base_url('daftar-permintaan-user'));
        }
        
        return $this->loadView('admin.dashboard', $data);
    }

    public function aw(){
        echo base64_encode("333" . "#" . "pgmm" . "#" . "60834556");
    }
}
