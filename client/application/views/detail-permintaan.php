<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Go Barang Bukti dan Tilang" name="description" />
    <meta content="Rafli Firdausy Irawan" name="author" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= asset('bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('bower_components/Ionicons/css/ionicons.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('dist/css/AdminLTE.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('dist/css/skins/_all-skins.min.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="<?= asset('bower_components/morris.js/morris.css') ?>">
    <link rel="stylesheet" href="<?= asset('bower_components/jvectormap/jquery-jvectormap.css') ?>">
    <link rel="stylesheet" href="<?= asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') ?>">
    <link rel="stylesheet" href="<?= asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
    <title>Detail Permintaan Barang Bukti</title>
</head>

<body style="font-family: Times New Roman">
    <div class="row">
        <div class="col-xs-12">
            <img src="<?= asset("img/gobang-logo.png") ?>" height="60px" alt="">
            <img src="<?= asset("img/kejaksaan-logo.png") ?>" style="margin-left:5px" height="60px" alt="">
            <img src="<?= asset("img/pos-logo.png") ?>" height="60px" alt="">            
        </div>
    </div>
    <div class="row">
        <div class="text-center" style="margin-top: 20px">
            <h4 style="font-family: Times New Roman;font-weight: bold; padding-bottom:0px;"><u>DETAIL PERMINTAAN BARANG BUKTI</u></h4>
            <h5 style="font-family: Times New Roman;font-weight: bold; margin-top:-5px">No : <?= $no ?> / GB-02 / GOBANG / <?= numberToRomawi(date('m')) ?> / <?= date('Y') ?></h5>
        </div>
    </div>
    <br>
    <div class="row" style="text-align:justify; text-justify:inter-word">
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Berdasarkan data permintaan pengiriman barang bukti tilang yang masuk pada sistem Go Barang Bukti dan Tilang (Gobang) sampai tanggal
            <?= date('d M Y'); ?> adalah sebanyak <?= $data_permintaan["total_permintaan"] ?> buah. Detail Data yang di telah dilakukan Shettlement Oleh pihak PT POS Indonesia, yaitu  :
        </p>
        <div class="table">
            <table style="border: none;" class="table">
                <thead>
                    <tr>
                        <th width="30%">Pembayaran Berhasil</th>
                        <th>: <?= sizeof($data_permintaan["data"]) ?> Barang Bukti</th>
                    </tr>
                    <tr>
                        <th width="30%">Pembayaran Gagal</th>
                        <th>: <?= sizeof($data_gagal["data"]) ?> Barang Bukti</th>
                    </tr>
                </thead>
            </table>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Berikut lampiran data yang berhasil kami lakukan pembayaran :
            </p>
            <table cellpadding="10" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="padding:5px;">No</th>
                        <th style="padding:5px;">No Reg Tilang</th>
                        <th style="padding:5px;">Nama Terpidana</th>
                        <th style="padding:5px;">Alamat</th>
                        <th style="padding:5px;">Nomer Hp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data_permintaan["data"] as $item) : ?>
                        <tr>
                            <td style="padding:5px; text-align:center;"><?= $no++; ?></td>
                            <td><?= $item->no_reg_tilang ?></td>
                            <td><?= $item->nama_terpidana ?></td>
                            <td>
                                <?= $item->detail_alamat ?>, <?= $item->alamat_antar ?> <?= $item->kode_pos ?>
                            </td>
                            <td><?= $item->nomer_hp ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if(sizeof($data_gagal["data"]) > 0) : ?>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Berikut lampiran data yang gagal kami lakukan pembayaran :
            </p>
            <table cellpadding="10" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="padding:5px;">No</th>
                        <th style="padding:5px;">No Reg Tilang</th>
                        <th style="padding:5px;">Nama Terpidana</th>
                        <th style="padding:5px;">Alamat</th>
                        <th style="padding:5px;">Nomer Hp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data_gagal["data"] as $item) : ?>
                        <tr>
                            <td style="padding:5px; text-align:center;"><?= $no++; ?></td>
                            <td><?= $item->no_reg_tilang ?></td>
                            <td><?= $item->nama_terpidana ?></td>
                            <td>
                                <?= $item->detail_alamat ?>, <?= $item->alamat_antar ?> <?= $item->kode_pos ?>
                            </td>
                            <td><?= $item->nomer_hp ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif ?>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Demikian Detail Permintaan Barang Bukti ini di buat untuk digunakan pihak Kejaksaan 
                menyiapkan dan melakukan pengecekan berkas bukti tilang sebelum di serahkan kepada 
                pihak PT POS Indonesia
            </p>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col">
            <div class="col-xs-3 pull-right">
                Purwokerto, <?= date("d M Y") ?>
            </div>
        </div>
        <div class="col">
            <div class="col-xs-3 pull-left">
                Kejaksaan
                <br><br><br><br>
                __________________________
            </div>
            <div class="col-xs-3 pull-right">
                PT POS Indonesia
                <br><br><br><br>
                __________________________
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3" style="margin: 0 auto; float: none; text-align: center;">
            Mengetahui
            <br>
            <br><br><br><br>
            __________________________
        </div>
    </div>

    <div class="row" style="position:fixed; bottom:0; right:0; left:0;">

    </div> -->
</body>

</html>