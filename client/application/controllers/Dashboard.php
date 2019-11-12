<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data["aktif"] = "dashboard";
        return $this->loadView('admin.dashboard', $data);
    }

    public function aw(){
        echo base64_encode("333" . "#" . "pgmm" . "#" . "60834556");
    }
}
