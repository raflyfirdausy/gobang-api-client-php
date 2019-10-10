<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function ___construct(){
        parent::___construct();
    }

    public function index(){
        return view('admin.dashboard');
    }
}
