<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Input_nomor_resi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data["title"]              = "Input Nomor Resi";
        $data["aktif"]              = "input_resi";
        return $this->loadView('input-nomor-resi.show', $data);
    }

    public function get_data()
    {
        $data   = $this->m_data->select(array(
            "permintaan_user.no_reg_tilang as no_reg_tilang",
            "permintaan_user.nama_penerima as nama_penerima",
            "permintaan_user.alamat_antar as alamat_antar",
            "permintaan_user.detail_alamat as detail_alamat",
            "permintaan_user.kode_pos as kode_pos",            
            "permintaan_user.nomer_hp as nomer_hp",
            "bb_status.no_resi as no_resi",
            "bb_status.id_bb_status as id_bb_status"
        ));
        $data   = $this->m_data->getJoin(
            "permintaan_user",
            "bb_status.id_permintaan = permintaan_user.id_permintaan",
            "INNER"
        );
        $data   = $this->m_data->getWhere("bb_status.no_resi", NULL);
        $data   = $this->m_data->getData("bb_status")->result();

        echo json_encode($data);
        // echo json_encode($data[0]->no_reg_tilang);
    }
}
