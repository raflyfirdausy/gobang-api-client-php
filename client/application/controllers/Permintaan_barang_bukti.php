<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_barang_bukti extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ajax_get_detail_permintaan($id_permintaan_bb = NULL){
        $dataSukses = $this->get_permintaan_bb($id_permintaan_bb, 1);
        $dataGagal  = $this->get_permintaan_bb($id_permintaan_bb, 2);

        $result = array(
            "sukses"    => $dataSukses,
            "gagal"     => $dataGagal
        );

        d($result);
    }

    public function get_permintaan_bb($id_permintaan_bb = NULL, $kode_req){
        $detail = $this->m_data->select(array(
            "bb_status.*", "permintaan_user.*", "daftar_terpidana.*"
        ));
        $detail = $this->m_data->getJoin(
            "detail_permintaan_bb",
            "permintaan_bb.id_permintaan_bb = detail_permintaan_bb.id_permintaan_bb",
            "RIGHT"
        );
        $detail = $this->m_data->getJoin(
            "bb_status",
            "bb_status.id_bb_status = detail_permintaan_bb.id_bb_status",
            "INNER"
        );
        $detail = $this->m_data->getJoin(
            "permintaan_user",
            "permintaan_user.id_permintaan = bb_status.id_permintaan",
            "INNER"
        );
        $detail = $this->m_data->getJoin(
            "daftar_terpidana",
            "daftar_terpidana.no_reg_tilang = permintaan_user.no_reg_tilang",
            "INNER"
        );
        $detail   = $this->m_data->getWhere("permintaan_bb.id_permintaan_bb", $id_permintaan_bb);
        $detail   = $this->m_data->getWhere("bb_status.req", $kode_req);
        $detail   = $this->m_data->getData("permintaan_bb")->result();

        $detailnya = array(
            "total_permintaan"  => sizeof($detail),
            "data"              => $detail
        );

        return $detailnya;
    }

    public function index(){
        
        $data_permintaan_bb     = $this->m_data->getData("permintaan_bb")->result();
        // d($data_permintaan_bb);

        $data["data_permintaan_bb"] = $data_permintaan_bb;
        $data["title"]              = "Permintaan Barang Bukti";
        $data["aktif"]              = "permintaan_barang_bukti";
        return $this->loadView('permintaan-barang-bukti.show', $data);
    }
}