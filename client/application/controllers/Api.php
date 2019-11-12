<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends MY_Controller
{

    public function index()
    {
        echo "Access Denied!";
    }

    public function get_daftar_terpidana($no_reg_tilang = NULL){
        if($no_reg_tilang != NULL){
            $cekDaftarTerpidana     = $this->m_data->getWhere("no_reg_tilang", $no_reg_tilang);
            $cekDaftarTerpidana     = $this->m_data->getData("daftar_terpidana")->row();
            if($cekDaftarTerpidana != NULL){
                echo json_encode(array(
                    "respon_code"   => 1,
                    "respon_mess"   => "Data Ditemukan!",
                    "data"          => $cekDaftarTerpidana
                ));
            } else {
                echo json_encode(array(
                    "respon_code"   => 0,
                    "respon_mess"   => "Data Tidak Ditemukan!",
                    "data"          => NULL
                ));
            }
        } else {
            echo json_encode(array(
                "respon_code"   => 0,
                "respon_mess"   => "No Reg Tilang tidak ditemukan",
                "data"          => NULL
            ));
        }
    }
}
