<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataTilang extends MY_Controller
{
    public function ___construct()
    {
        parent::___construct();
    }

    public function index()
    {
        return $this->loadView('data-tilang.show');
    }
}
