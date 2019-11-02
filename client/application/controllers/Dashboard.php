<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function ___construct(){
        parent::___construct();        
    }

    public function index(){
        return $this->loadView('admin.dashboard');
    }
}
