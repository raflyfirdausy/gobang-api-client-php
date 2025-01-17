<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kejaksaan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $userData = $this->m_data->getWhere("user_id", $this->session->userdata("login")->user_id);
        $userData = $this->m_data->getData("admin")->row();
        if ($userData->level !== "super_admin") {
            redirect(base_url());
        }
    }
    
    public function index()
    {

        $admin = $this->m_data->select(array(
            "admin.user_id as user_id",        
            "admin.nama as nama",
            "admin.email as email",
            "admin.no_hp as no_hp",
            "admin.alamat as alamat",
            "admin.jenis_kelamin as jenis_kelamin"            
        ));        
        $admin  = $this->m_data->getWhere("level", "admin");
        $admin  = $this->m_data->getData('admin')->result();

        foreach ($admin as $a) {
            $a->jenis_kelamin = $a->jenis_kelamin == "0" ? "Wanita" : "Pria";
        }

        // die(json_encode($admin));

        // $faker = faker();
        // $dataFake = array();
        // for ($i=0; $i < 100; $i++) { 
        //     $datax = array(
        //         "nik"  => $faker->nik,
        //         "nama"  => $faker->name,
        //         "email" => $faker->email,
        //         "no_hp" => $faker->e164PhoneNumber,
        //         "jenis_kelamin" => "laki - laki"
        //     );
        //     array_push($dataFake, $datax);
        // }

        // $data = array(
        //     // "faker" => $dataFake,
        //     "admin" => $admin
        // );
        $data["admin"]  = $admin;
        $data["aktif"]  = "petugas";
        return $this->loadView('petugas.kejaksaan.show-kejaksaan', $data);
    }

    public function tambah()
    {
        return $this->loadView('petugas.kejaksaan.tambah-kejaksaan');
    }
}
