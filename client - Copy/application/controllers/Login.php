<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function ___construct(){
        parent::___construct();
    }

    public function index(){
        $this->load->view('v_login');
    }
}
