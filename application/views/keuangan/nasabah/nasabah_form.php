<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?= $box; ?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'><?= $title ?></h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo site_url($action); ?>" method="post">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_karyawan" class="control-label">ID Nasabah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="id_nasabah" id="id_nasabah" data-error="Masukan Kode Jenjang" placeholder="Kode Jenjang" value="<?php echo $id_nasabah; ?>" required readonly />
                                    <span class="input-group-addon">
                                        <span class="fas fa-id-badge"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="jabatan" class="control-label">Nama
                                    Nasabah<?php echo form_error('nama_nasabah') ?></label>
                                <div class="input-group">
                                    <?php
                                    if ($action == 'update_nasabah') {
                                        echo cmb_dinamis('nps', 'nps', 'siswa', 'nama_siswa', 'nama_siswa', $nama_siswa);
                                    } else {
                                        echo cmb_dinamis('nps', 'nps', 'siswa', 'nama_siswa', 'nps', $nama_siswa);
                                    }
                                    ?>
                                    <span class="input-group-addon">
                                        <span class="fas fa-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nps" class="control-label">NPS (Nomor Pokok Santri)</label>
                                <div class="input-group">
                                    <input type="hidden" class="form-control" name="nama_siswa" id="nama_siswa" data-error="Masukan NPS" placeholder="Nama Nasabah" value="<?php echo $nama_siswa; ?>" required readonly />
                                    <input type="text" class="form-control" name="nps" id="nomor_pokok_santri" data-error="Masukan NPS" placeholder="NPS" value="<?php echo $nps; ?>" required readonly />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nps" class="control-label">Orang Tua Santri</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="orang_tua" data-error="Data Orang Tua Santri" placeholder="Orang Tua Santri" value="<?php echo $orang_tua; ?>" required readonly />
                                    <span class="input-group-addon">
                                        <span class="fas fa-users"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                                <a href="<?php echo site_url('nasabah') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="jabatan" class="control-label">Kelas
                                    <?php echo form_error('kode_kelas') ?></label>
                                <div class="input-group">
                                    <?php echo cmb_dinamis('kode_kelas', 'kode_kelas', 'kelas', 'kode_kelas', 'kode_kelas', $kode_kelas) ?>
                                    <span class="input-group-addon">
                                        <span class="fas fa-school"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="jabatan" class="control-label">Status
                                    <?php echo form_error('status') ?></label>
                                <div class="input-group">
                                    <select class="form-control" name="status">
                                        <option>--Pilih Status--</option>
                                        <option value="Y" <?php echo  set_select('status', 'aktif') . (!empty($status) && $status == "Y" ? "selected = 'selected'" : ""); ?>>
                                            Aktif</option>
                                        <option value="T" <?php echo  set_select('status', 'tidak aktif'); ?>>
                                            Tidak Aktif</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <span class="fas fa-question-circle"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jabatan" class="control-label">Saldo Utama
                                    <?php echo form_error('status') ?></label>
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-lg" id="rp_utama" name="ss" value="<?= $saldo_utama ?>" autocomplete="off" />
                                    <input type="text" class="form-control input-lg" id="" name="saldo_utama" autofocus=”autofocus” value="Rp. <?= rupiah($saldo_utama) ?>" autocomplete="off" />
                                    <span class="input-group-addon">
                                        <span class="fas fa-dollar-sign"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jabatan" class="control-label">Saldo Sementara
                                    <?php echo form_error('status') ?></label>
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-lg" id="rp_sementara" name="saldo_sementara" value="<?= $saldo_sementara ?>" autocomplete="off" />
                                    <input type="text" class="form-control input-lg" id="rupiah2" name="saldo_sementara" autofocus=”autofocus” value="Rp. <?= rupiah($saldo_sementara) ?>" autocomplete="off" />
                                    <span class="input-group-addon">
                                        <span class="fas fa-dollar-sign"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jabatan" class="control-label">Pengeluran
                                    <?php echo form_error('status') ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" id="" name="pengeluaran" autofocus=”autofocus” value="Rp. <?= rupiah($pengeluaran) ?>" autocomplete="off" />
                                    <span class="input-group-addon">
                                        <span class="fas fa-dollar-sign"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<!-- Ajax -->
<script type="text/javascript">
    var dengan_rupiah = document.getElementById('rupiah');
    var dengan_rupiah2 = document.getElementById('rupiah2');

    dengan_rupiah.addEventListener('keyup',
        function(e) {
            // document.getElementById('no_rupiah').value = dengan_rupiah.value;
            dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
        });
    dengan_rupiah2.addEventListener('keyup',
        function(e) {
            // document.getElementById('no_rupiah').value = dengan_rupiah.value;
            dengan_rupiah2.value = formatRupiah(this.value, 'Rp. ');
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

    $('#nps').on('change', function() {
        var nps = $(this).val();
        if (nps != '') {
            $.ajax({
                url: '<?= base_url() ?>/tambahnasabah/get_siswa',
                method: 'POST',
                dataType: 'json',
                data: {
                    nps: nps,
                },
                success: function(data) {
                    $('#nomor_pokok_santri').val(data['nps']);
                    $('#nama_siswa').val(data['nama_siswa']);
                }
            });
        }
    });
</script>
<?php
function rupiah($rp)
{
    if ($rp != 0) {
        $hasil = number_format($rp, 0, ',', '.');
    } else {
        $hasil = 0;
    }
    return $hasil;
}
?>