<!-- Main content -->
<style media="screen">
    table,
    th,
    tr {
        text-align: center;
    }

    .dataTables_wrapper .dt-buttons {
        float: none;
        text-align: center;
    }

    .sfwal2-popup {
        font-family: inherit;
        font-size: 1.2rem;
    }

    div.dataTables_wrapper div.dataTables_length label {
        padding-top: 5px;
        font-weight: normal;
        text-align: left;
        white-space: nowrap;
    }

    .swal2-popup {
        font-family: inherit;
        font-size: 1.2rem;
    }

    .input-lg {
        font-size: 32px;
    }
</style>
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-success'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>Update Setoran Tunai</h3>
                    <div class="pull-right">
                    </div>
                </div>
                <div class="box-body">
                </div>

                <div class="box-body">
                    <form action="<?= site_url($action) ?>" enctype="multipart/form-data" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="id">ID Transaksi :</label>
                                <input type="text" class="form-control" disabled value="<?php echo $id_transaksi; ?>" />
                                <input type="hidden" class="form-control" name="id_transaksi" value="<?php echo $id_transaksi; ?>" />


                                <label for="nama">ID Nasabah :</label>
                                <input type="hidden" class="form-control" name="nps" value="<?php echo $nasabah->nps; ?>" />
                                <input type="hidden" class="form-control" name="id_nasabah" value="<?php echo $nasabah->id_nasabah; ?>" />
                                <input type="text" disabled class="form-control" value="<?php echo $nasabah->id_nasabah; ?>" />

                                <label for="alamat">Nama :</label>
                                <input class="form-control" disabled value="<?php echo $nasabah->nama_nasabah; ?>">

                                <label for="username">Alamat :</label>
                                <input type="text" disabled class="form-control" value="<?php echo $nasabah->alamat; ?>" disabled />

                                <label for="password">Orang Tua :</label>
                                <input type="text" class="form-control" value="<?php echo $nasabah->orang_tua; ?>" disabled />

                            </div>
                            <div class="col-md-6">

                                <label for="password">Saldo :</label>
                                <h3>Rp. <?php echo rupiah($nasabah->saldo_utama); ?>
                                </h3>

                                <label for="password">Saldo Bulan ini :</label>
                                <h3>Rp. <?php echo rupiah($nasabah->saldo_utama); ?></h3>

                                <label for="password">Jumlah Setoran :</label>
                                <!-- <input type="hidden" class="form-control" name="kredit" /> -->
                                <input type="text" class="form-control input-lg" id="rupiah" name="kredit" autofocus=”autofocus” value="<?= $kredit ?>" autocomplete="off" />
                                <label for="password">Saldo :</label>
                                <!-- <input type="hidden" class="form-control" name="kredit" /> -->
                                <input type="text" class="form-control input-lg" id="rupiah" name="saldo" autofocus=”autofocus” value="<?= $kredit ?>" autocomplete="off" />

                                <label for="alamat">Keterangan :</label>
                                <input type="text" class="form-control input-lg" name="keterangan" autofocus=”autofocus” value="<?= $keterangan ?>" autocomplete="off" />

                            </div>

                        </div>


                        <div class="ln_solid mb-5"></div>
                        <div class="form-group">
                            <?php echo anchor(site_url('transaksi_nasabah/' . $nasabah->nps), ' <i class="fa fa-close fa-2x"></i> &nbsp;&nbsp; Batal', ' class="btn btn-danger btn-lg btn-create-data btn3d" hidden="true" onclick="self.history.back()"'); ?>
                            <!-- <button type="button" class="btn btn-default btn-md" onclick=self.history.back()><i
                                    class="fa fa-file-upload fa-2x"></i> Batal</button> -->
                            <button type="submit" name="tunai" class="btn btn-success btn-lg btn-create-data btn3d"><?= $button ?></button>
                            <br>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<!-- <php endforeach; ?> -->
<script type="text/javascript">
    let base_url = '<?= base_url() ?>';
</script>
<script type="text/javascript">
    let checkLogin = '<?= $result ?>';

    var dengan_rupiah = document.getElementById('rupiah');
    dengan_rupiah.addEventListener('keyup',
        function(e) {
            // document.getElementById('no_rupiah').value = dengan_rupiah.value;
            dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
        });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
<script src="<?php echo base_url() ?>assets/app/datatables/nasabah_detail.js" charset="utf-8"></script>
<?php
function rupiah($rp)
{
    if ($rp != 0) {
        $hasil = number_format($rp, 2, '.', ',');
    } else {
        $hasil = 0;
    }
    return $hasil;
}
?>