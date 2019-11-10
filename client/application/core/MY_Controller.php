<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();     
        
        $CI->encryption->initialize(
            array(
                'cipher' => 'aes-256',
                'mode' => 'ctr'
            )
        );  

        if ($this->router->fetch_class() != "auth") {
            if (!$this->session->has_userdata('login')) {
                redirect(base_url("login"));
            }            
        } 

        if($CI->session->userdata('login')){
            $userData = $this->m_data->getWhere("nip", $CI->session->userdata("login")->nip);
            $userData = $this->m_data->getData("admin")->row();
        } else {
            $userData = NULL;
        }                    

        $permintaan_bb   = $this->m_data->getJoin(
            "permintaan_user", 
            "bb_status.id_permintaan = permintaan_user.id_permintaan",
            "INNER"
        );
        $permintaan_bb   = $this->m_data->getJoin(
            "daftar_terpidana", 
            "permintaan_user.no_reg_tilang = daftar_terpidana.no_reg_tilang",
            "INNER"
        );
        $permintaan_bb   = $this->m_data->getWhere("bb_status.req", 0);
        $permintaan_bb   = $this->m_data->getWhere("daftar_terpidana.posisi", "kejaksaan");
        $permintaan_bb   = $this->m_data->getData("bb_status")->num_rows();        
        
        $this->global_data = [
            "app_name"          => "Go Bang",
            "app_complete_name" => "Go Barang Bukti dan Tilang",
            "CI"                => $CI,
            "user_data"         => $userData,
            "aktif"             => NULL,
            "g_permintaan_bb"   => $permintaan_bb
        ];    
    }

    function loadView($view, $local_data = array())
    {
        $data = array_merge($this->global_data, $local_data);
        return view($view, $data);
    }
}
