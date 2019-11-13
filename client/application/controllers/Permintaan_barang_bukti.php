<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_barang_bukti extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ajax_get_detail_permintaan($id_permintaan_bb = NULL)
    {
        $dataSukses = $this->get_permintaan_bb($id_permintaan_bb, 1);
        $dataGagal  = $this->get_permintaan_bb($id_permintaan_bb, 2);

        $result = array(
            "sukses"    => $dataSukses,
            "gagal"     => $dataGagal
        );

        d($result);
    }

    public function download_detail_permintaan_barang_bukti($id = NULL)
    {
        if ($id == NULL) {
            redirect(base_url('permintaan-barang-bukti'));
        } else {            
            $data["data_permintaan"]    = $this->get_permintaan_bb($id, 1); // 1 kode req sukses
            $data["data_gagal"]         = $this->get_permintaan_bb($id, 2); // 2 kode ga di req (gagal)                
            $data["qr_code"]            = RFL_ENCRYPT($id);
            $data["no"]                 = $id;
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($this->load->view('detail-permintaan', $data, TRUE));            
            $filename = "DETAIL_PERMINTAAN_NO_" . $id . "_" . date("d_m_Y_H_i_s") . ".pdf";
            $mpdf->Output($filename, 'D');
        }
    }

    public function konfirmasi_barang_bukti(){
        $nomor_permintaan = $this->input->post('nomor_permintaan');   
        $dataSukses = $this->get_permintaan_bb($nomor_permintaan, 1);
                
        foreach($dataSukses["data"] as $item){
            $updateStatus = $this->m_data->update(
                "daftar_terpidana",
                ["posisi" => "pos"], // 1 sukses | 2 gagal
                ["no_reg_tilang"  => $item->no_reg_tilang]
            );
        }

        $update = $this->m_data->update(
            "permintaan_bb",
            ["acc_kejaksaan" => 1],
            ["id_permintaan_bb"  => $nomor_permintaan]
        );

        if($update > 0){
            $this->session->set_flashdata("sukses", "Permintaan barang bukti nomor $nomor_permintaan berhasil di konfirmasi." );                    
        } else {
            $this->session->set_flashdata("gagal", "Gagal melakukan konfirmasi . Terjadi Kesalahan pada server");                    
        }
        redirect(base_url("/permintaan-barang-bukti"));
    }

    public function get_permintaan_bb($id_permintaan_bb = NULL, $kode_req)
    {
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

    public function index()
    {
        $data_permintaan_bb     = $this->m_data->order_by("id_permintaan_bb", "DESC");
        $data_permintaan_bb     = $this->m_data->getData("permintaan_bb")->result();

        $data["data_permintaan_bb"] = $data_permintaan_bb;
        $data["title"]              = "Permintaan Barang Bukti";
        $data["aktif"]              = "permintaan_barang_bukti";
        return $this->loadView('permintaan-barang-bukti.show', $data);
    }
}
