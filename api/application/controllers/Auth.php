<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends MY_Controller
{
    public function index_get()
    {
        $this->set_response(array(
            "nama" => "rafli"
        ), 200);
    }
}
