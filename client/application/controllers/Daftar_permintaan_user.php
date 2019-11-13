<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_permintaan_user extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_detail_permintaan($id_permintaan = NULL, $kode_req = NULL)
    {
        if ($id_permintaan == NULL || $kode_req == NULL) {
            $this->session->set_flashdata("gagal", "Terjadi kesalahan pada id perminaan atau kode request");
            redirect(base_url("daftar-permintaan-user"));
        } else {
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
            $detail   = $this->m_data->getWhere("permintaan_bb.id_permintaan_bb", $id_permintaan);
            $detail   = $this->m_data->getWhere("bb_status.req", $kode_req);
            $detail   = $this->m_data->getData("permintaan_bb")->result();

            $detailnya = array(
                "total_permintaan"  => sizeof($detail),
                "data"              => $detail
            );

            return $detailnya;
        }
    }

    public function get_permintaan_bb($kode = NULL)
    {
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
        $permintaan_bb   = $this->m_data->getWhere("bb_status.req", $kode == null ? 0 : $kode);
        $permintaan_bb   = $this->m_data->getWhere("daftar_terpidana.posisi", "kejaksaan");
        $permintaan_bb   = $this->m_data->getData("bb_status")->result();

        $data_permintaan = array(
            "total_permintaan"  => sizeof($permintaan_bb),
            "data"              => $permintaan_bb
        );
        return $data_permintaan;
    }

    public function tes()
    {
        echo RFL_DECRYPT("4e54413d");
    }

    public function index()
    {
        $data["data_permintaan"]    = $this->get_permintaan_bb();
        $data["title"]              = "Daftar Permintaan User";
        $data["aktif"]              = "daftar_permintaan_user";
        return $this->loadView('daftar-permintaan-user.show', $data);
    }

    public function download_berita_acara()
    {
        $data_permintaan    = $this->get_permintaan_bb();
        $selected_id        = $this->input->post('selected_id');
        $selected_id        = explode(",", $selected_id);

        //UBAH STATUS REQ DI TABLE BB_STATUS
        $errorUpdate = FALSE;
        foreach ($data_permintaan["data"] as $item) {
            $update = $this->m_data->update(
                "bb_status",
                ["req" => in_array($item->no_reg_tilang, $selected_id) ? 1 : 2], // 1 sukses | 2 gagal
                ["id_bb_status"  => $item->id_bb_status]
            );
            if ($update < 1) {
                $errorUpdate = TRUE;
                break;
            }
        }

        if (!$errorUpdate) {
            //INSERT KE TABLE PERMIMNTAAN_BB
            if ($data_permintaan["total_permintaan"] > 0) {
                $insert_id = $this->m_data->insert("permintaan_bb", ["total_permintaan" => $data_permintaan["total_permintaan"]]);

                $dataInsertBatch = array();
                foreach ($data_permintaan["data"] as $item) {
                    $data = array(
                        "id_permintaan_bb"  => $insert_id,
                        "id_bb_status"      => $item->id_bb_status
                    );
                    array_push($dataInsertBatch, $data);
                }

                $this->m_data->insert_batch("detail_permintaan_bb", $dataInsertBatch);
                $this->session->set_flashdata("sukses", "Berhasil melakukan permintaan pengambilan barang bukti tilang.");

                $data["data_permintaan"]    = $this->get_detail_permintaan($insert_id, 1); // 1 kode req sukses
                $data["data_gagal"]         = $this->get_detail_permintaan($insert_id, 2); // 2 kode ga di req (gagal)                
                $data["qr_code"]            = RFL_ENCRYPT($insert_id);
                $data["no"]                 = $insert_id;
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($this->load->view('berita-acara', $data, TRUE));
                $mpdf->AddPage();
                $mpdf->WriteHTML($this->load->view('berita-acara', $data, TRUE));
                $filename = "BERITA_ACARA_" . date("d_m_Y_H_i_s") . ".pdf";
                $mpdf->Output($filename, 'D');                
            } else {
                $this->session->set_flashdata("gagal", "Tidak ada barang bukti yang bisa di lakukan permintaan");
                redirect(base_url("daftar-permintaan-user"));
            }
        }
    }
}
