<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function index()
    {
        if ($this->session->has_userdata('login')) {
            redirect(base_url("dashboard"));
        }
        return $this->loadView('login');        
    }

    public function proses_login()
    {
        $email    = $this->input->post("email");
        $password = $this->input->post("password");

        $cekLogin = $this->m_data->getWhere("email", $email);
        $cekLogin = $this->m_data->getWhere("password", $password);
        $cekLogin = $this->m_data->getData("admin")->row();

        if ($cekLogin) {
            $this->m_data->update(
                "admin",
                ["last_login" => date("Y-m-d H:i:s")],
                ["user_id" => $cekLogin->user_id]
            );
            $this->session->set_userdata("login", $cekLogin);
            redirect(base_url("dashboard"));
        } else {
            $this->session->set_flashdata("gagal", "Maaf kombinasi email dan password salah!");
            $this->index();
        }
    }

    public function proses_logout()
    {
        $this->session->sess_destroy();
        redirect(base_url("login"));
    }
}
