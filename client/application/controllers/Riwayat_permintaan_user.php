<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_permintaan_user extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ajax_get_data_permintaan($id_permintaan = NULL){
        if(sizeof($this->get_data_permintaan($id_permintaan)) > 0){
            $result = array(
                "status"    => 1,
                "data"      => $this->get_data_permintaan($id_permintaan)[0]
            );
        } else {
            $result = array(
                "status"    => 0,
                "data"      => NULL);
        }

        echo json_encode($result);
    }

    public function get_data_permintaan($id_permintaan = NULL){
        $data_permintaan    = $this->m_data->select(array(
            "permintaan_user.*",
            "permintaan_user.created_at as waktu_permintaan",
            "bb_status.id_bb_status as id_bb_status",
            "bb_status.no_resi as no_resi",            
            "bb_status.created_at as waktu_pembayaran",
            "daftar_terpidana.*"            
        ));
        
        $data_permintaan    = $this->m_data->getJoin(
            "bb_status",
            "permintaan_user.id_permintaan = bb_status.id_permintaan",
            "LEFT"
        );
        
        $data_permintaan    = $this->m_data->getJoin(
            "daftar_terpidana",
            "permintaan_user.no_reg_tilang = daftar_terpidana.no_reg_tilang",
            "INNER"
        );
        if($id_permintaan != NULL){
            $data_permintaan    = $this->m_data->getWhere("permintaan_user.id_permintaan", $id_permintaan);
        }

        $data_permintaan    = $this->m_data->order_by("permintaan_user.created_at", "DESC");
        $data_permintaan    = $this->m_data->getData("permintaan_user")->result();        
        // echo json_encode( $data_permintaan);
        return $data_permintaan;
    }

    public function index($tanggal_awal = NULL, $tanggal_akhir = NULL)
    {        
        $data_permintaan = $this->get_data_permintaan();
        foreach($data_permintaan as $item){
            $item->total_biaya = (int) $item->nominal_denda + 
                                 (int) $item->nominal_perkara +
                                 (int) $item->nominal_pos +
                                 (int) $item->nominal_gobang;

            if($item->waktu_expired < date("Y-m-d H:i:s")){
                $item->status_riwayat = "Expired";
            } else {
                if($item->id_bb_status == NULL){
                    $item->status_riwayat = "Menunggu Pembayaran";
                } else {
                    if($item->posisi == "kejaksaan"){
                        $item->status_riwayat = "Menunggu Rekonsiliasi";
                    } else {
                        if($item->no_resi == NULL){
                            $item->status_riwayat = "Proses Rekonsiliasi";
                        } else {
                            if($item->posisi == "selesai"){
                                $item->status_riwayat = "Selesai";
                            } else {
                                $item->status_riwayat = "Dikirim";
                            }
                        }
                    }
                }
            }            
        }        

        // d($data_permintaan);
        
        $data["title"]              = "Riwayat Permintaan User";
        $data["aktif"]              = "riwayat_permintaan_user";
        $data["data_permintaan"]    = $data_permintaan;
        return $this->loadView('permintaan-user.show', $data);
    }
}
