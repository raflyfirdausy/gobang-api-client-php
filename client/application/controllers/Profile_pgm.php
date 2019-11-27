<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Profile_pgm extends MY_Controller
{
    public function ___construct()
    {
        parent::___construct();    
    }

    public function index(){
        $data["aktif"] = "profile_pgm";
        redirect(base_url());
        return $this->loadView('pgm.profile', $data);
    }
}