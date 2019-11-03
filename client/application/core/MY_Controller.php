<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();

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

        $this->global_data = [
            "app_name"          => "Go Bang",
            "app_complete_name" => "Go Barang Bukti dan Tilang",
            "CI"                => $CI,
            "user_data"         => $userData,
            "aktif"             => NULL
        ];
    }

    function loadView($view, $local_data = array())
    {
        $data = array_merge($this->global_data, $local_data);
        return view($view, $data);
    }
}
