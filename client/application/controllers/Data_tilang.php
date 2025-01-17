<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Data_tilang extends MY_Controller
{
    public function ___construct()
    {
        parent::__construct();
    }

    public function index($tanggal_awal = NULL, $tanggal_akhir = NULL)
    {

        if ($tanggal_awal == NULL || $tanggal_akhir == NULL) {
            $tanggal_awal  = date("d-m-Y", strtotime("-1 months"));
            $tanggal_akhir   = date("d-m-Y");        

            redirect(base_url('data-tilang/index/') . $tanggal_awal . "/" . $tanggal_akhir);
        }

        // d(date("Y-m-d", strtotime($tanggal_awal)));

        $tanggal_awal  = date("Y-m-d", strtotime($tanggal_awal));
        $tanggal_akhir = date("Y-m-d", strtotime($tanggal_akhir . " +1 days"));      
        
        // d($tanggal_akhir);
        
        $dataTilang = $this->m_data->getWhere("created_at >=", $tanggal_awal);
        $dataTilang = $this->m_data->getWhere("created_at <=", $tanggal_akhir);
        $dataTilang = $this->m_data->order_by("created_at", "DESC");
        $dataTilang = $this->m_data->getWhere("created_at <=", date('Y-m-d', strtotime($tanggal_akhir)));
        $dataTilang = $this->m_data->getData("daftar_terpidana")->result();        
        
        $data["aktif"] = "data_tilang";
        $data["dataTilang"] = $dataTilang;
        return $this->loadView('data-tilang.show', $data);
    }

    public function import_tilang()
    {
        if (!empty($_FILES["file_excel"]["name"])) {
            $extension = pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION);

            $benar = TRUE;
            if ($extension == 'csv') {
                $reader = new Csv();
            } else if ($extension == 'xlsx') {
                $reader = new Xlsx();
            } else if ($extension == 'xls') {
                $reader = new Xls();
            } else {
                $benar = FALSE;                
            }

            if ($benar) {
                $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
                $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $aktifSheet = $spreadsheet->getActiveSheet();
                            
                $data_error = array();
                $sukses = 0;
                $gagal = 0;
                $awalData = 4;
                for ($i = $awalData; $i <= count($allDataInSheet); $i++) {
                    if (
                        !is_numeric($aktifSheet->getCell('A' . $i)->getValue()) ||
                        $aktifSheet->getCell('A' . $i)->getValue() == "JUMLAH"
                    ) {
                        break;
                    } else {
                        // // $tgl_penitipan = $aktifSheet->getCell('F' . $i)->getValue();
                        // $tgl_penitipan = $allDataInSheet[$i]["F"];
                        // $tgl_penitipan = str_replace('/', '-', $tgl_penitipan);
                        // $tgl_penitipan = date("Y-m-d", strtotime($tgl_penitipan));

                        // // $tgl_putusan = $aktifSheet->getCell('H' . $i)->getValue();
                        // $tgl_putusan = $allDataInSheet[$i]["H"];
                        // $tgl_putusan = str_replace('/', '-', $tgl_putusan);
                        // $tgl_putusan = date("Y-m-d", strtotime($tgl_putusan));

                        $tgl_perkara = $allDataInSheet[$i]["C"];
                        $tgl_perkara = str_replace('/', '-', $tgl_perkara);
                        $tgl_perkara = date("Y-m-d", strtotime($tgl_perkara));

                        $tgl_putusan = $allDataInSheet[$i]["T"];
                        $tgl_putusan = str_replace('/', '-', $tgl_putusan);
                        $tgl_putusan = date("Y-m-d", strtotime($tgl_putusan));

                        $tgl_bayar = $allDataInSheet[$i]["Y"];
                        $tgl_bayar = str_replace('/', '-', $tgl_bayar);
                        $tgl_bayar = date("Y-m-d", strtotime($tgl_bayar));

                        $item   = array(
                            "no_reg_tilang"         => $aktifSheet->getCell('B' . $i)->getValue(),
                            "tgl_perkara"           => $tgl_perkara,
                            "form"                  => $aktifSheet->getCell('D' . $i)->getValue(),
                            "nomor_briva"           => $aktifSheet->getCell('E' . $i)->getValue(),
                            "nrp_petugas"           => $aktifSheet->getCell('F' . $i)->getValue(),
                            "nama_petugas"          => $aktifSheet->getCell('G' . $i)->getValue(),
                            "nama_terpidana"        => $aktifSheet->getCell('H' . $i)->getValue(),  
                            "alamat_terpidana"      => $aktifSheet->getCell('I' . $i)->getValue(),
                            "pasal"                 => $aktifSheet->getCell('J' . $i)->getValue(),
                            "barang_bukti"          => $aktifSheet->getCell('K' . $i)->getValue(),
                            "jenis_kendaraan"       => $aktifSheet->getCell('L' . $i)->getValue(),
                            "nomor_polisi"          => $aktifSheet->getCell('M' . $i)->getValue(),
                            "jumlah_penitipan"      => $aktifSheet->getCell('N' . $i)->getValue(),
                            "kode_satker_pn"        => $aktifSheet->getCell('O' . $i)->getValue(),
                            "no_perkara"            => $aktifSheet->getCell('P' . $i)->getValue(),
                            "nama_hakim"            => $aktifSheet->getCell('Q' . $i)->getValue(),
                            "nama_panitera"         => $aktifSheet->getCell('R' . $i)->getValue(),
                            "kode_satker_kejaksaan" => $aktifSheet->getCell('S' . $i)->getValue(),
                            "tgl_putusan"           => $tgl_putusan,
                            "hadir_verstek"         => $aktifSheet->getCell('U' . $i)->getValue(),
                            "denda"                 => $aktifSheet->getCell('V' . $i)->getValue(),
                            "biaya_perkara"         => $aktifSheet->getCell('W' . $i)->getValue(),
                            "subsidair"             => $aktifSheet->getCell('X' . $i)->getValue(),
                            "tgl_bayar"             => $tgl_bayar,
                            "sisa_penitipan"        => $aktifSheet->getCell('Z' . $i)->getValue(),
                            "sisa_penitipan"        => "",
                            "posisi"                => "kejaksaan"
                        );

                        // $item = array(
                        //     "nama_terpidana" => $aktifSheet->getCell('B' . $i)->getValue(),
                        //     "no_reg_tilang" => $aktifSheet->getCell('C' . $i)->getValue(),
                        //     "alamat_terpidana" => $aktifSheet->getCell('D' . $i)->getValue(),
                        //     "nomor_briva" => $aktifSheet->getCell('E' . $i)->getValue(),
                        //     "tgl_penitipan" => $tgl_penitipan,
                        //     "jumlah_penitipan" => $aktifSheet->getCell('G' . $i)->getValue(),
                        //     "tgl_putusan" => $tgl_putusan,
                        //     "denda" => $aktifSheet->getCell('I' . $i)->getValue(),
                        //     "biaya_perkara" => $aktifSheet->getCell('J' . $i)->getValue(),                            
                        //     "posisi" => "kejaksaan"
                        // );

                        $insert = $this->m_data->insert("daftar_terpidana", $item);
                        if ($insert) {
                            $sukses++;
                        } else {
                            $gagal++;
                            $itemGagal = array(
                                "no"    => $aktifSheet->getCell('A' . $i)->getValue(),
                                "no_reg_tilang" => $aktifSheet->getCell('C' . $i)->getValue(),
                                "alasan" => $this->m_data->getError()
                            );
                            array_push($data_error, $itemGagal);
                        }
                    }
                }

                if ($gagal > 0) {
                    $this->session->set_flashdata("sukses", "Menambahkan " . $sukses . " Data");
                    $this->session->set_flashdata("gagal", $data_error);                    
                } else {
                    $this->session->set_flashdata("sukses", "Menambahkan " . $sukses . " Data");                    
                }                
            } else {
                $this->session->set_flashdata("gagal", "Format yang kamu masukan salah, silahkan upload file Excel sesuai dengan format yang sudah di tentukan");
            }
        } else {
            $this->session->set_flashdata("gagal", "File tidak ditemukan!");
        }
        $this->index();
    }

    public function hapus_tilang(){
        $no_reg_tilang   = $this->input->post('no_reg_tilang');
        $hapus           = $this->m_data->delete(array("no_reg_tilang" => $no_reg_tilang), "daftar_terpidana");
        if ($hapus > 0) {
            $this->session->set_flashdata("sukses", "Data berhasil di hapus dari database");
        } else {
            $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menghapus data");
        }
        $this->index();
    }
}
