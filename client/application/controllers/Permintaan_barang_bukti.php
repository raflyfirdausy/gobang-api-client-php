<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_barang_bukti extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_permintaan_bb(){
        $permintaan_bb   = $this->m_data->getJoin(
            "permintaan_user", 
            "bb_status.id_permintaan = permintaan_user.id_permintaan",
            "INNER"
        );
        $permintaan_bb   = $this->m_data->getJoin(
            "daftar_terpidana", 
            "permintaan_user.no_reg_tilang = daftar_terpidana.no_reg_tilang",
            "INNER"
        );
        $permintaan_bb   = $this->m_data->getWhere("bb_status.req", 0);
        $permintaan_bb   = $this->m_data->getWhere("daftar_terpidana.posisi", "kejaksaan");
        $permintaan_bb   = $this->m_data->getData("bb_status")->result();        

        $data_permintaan = array(
            "total_permintaan"  => sizeof($permintaan_bb),
            "data"              => $permintaan_bb
        );

        return $data_permintaan;
    }

    public function index(){                      
        $data["data_permintaan"]    = $this->get_permintaan_bb();
        $data["title"]              = "Permintaan Barang Bukti";
        $data["aktif"]              = "permintaan_bb";
        return $this->loadView('permintaan-bb.show', $data);
    }

    public function download_berita_acara(){       
        $data_permintaan = $this->get_permintaan_bb();

        //UBAH STATUS REQ DI TABLE BB_STATUS
        $errorUpdate = FALSE;             
        foreach($data_permintaan["data"] as $item){        
            $update = $this->m_data->update("bb_status", ["req" => 1], ["id_bb_status"  => $item->id_bb_status]);
            if($update < 1){
                $errorUpdate = TRUE;
                break;
            }
        }

        if(!$errorUpdate){
            //INSERT KE TABLE PERMIMNTAAN_BB
            if($data_permintaan["total_permintaan"] > 0){
                $insert_id = $this->m_data->insert("permintaan_bb", ["total_permintaan" => $data_permintaan["total_permintaan"]]);

                $dataInsertBatch = array();
                foreach($data_permintaan["data"] as $item){
                    $data = array(
                        "id_permintaan_bb"  => $insert_id,
                        "id_bb_status"      => $item->id_bb_status
                    );
                    array_push($dataInsertBatch, $data);
                }    
                
                $this->m_data->insert_batch("detail_permintaan_bb", $dataInsertBatch);
                $this->session->set_flashdata("sukses", "Berhasil melakukan permintaan pengambilan barang bukti tilang.");                        
                redirect(base_url("permintaan-barang-bukti"));
            } else {
                $this->session->set_flashdata("gagal", "Tidak ada barang bukti yang bisa di lakukan permintaan");    
                redirect(base_url("permintaan-barang-bukti"));
            }                        
        }        
    }
}