<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kejaksaan extends CI_Controller {
    public function ___construct(){
        parent::___construct();
    }

    public function index(){
        return view('petugas.kejaksaan.show-kejaksaan');
    }
}
