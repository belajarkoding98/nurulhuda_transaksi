<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?= $box; ?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORMULIR TAMBAH KEHILANGAN KARTU</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="" method="post">
                        <div class="col-lg-6">
                        <div class="form-group">
                                <label for="nama_siswa" class="control-label">Nama Siswa</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nama_siswa" id="nama_siswa"
                                        data-error="Nama Siswa harus diisi" placeholder="Nama Siswa"
                                        value="" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="jk_siswa" class="control-label">Jenis
                                    Kelamin<?php echo form_error('jk_siswa') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="jk_siswa" data-error="Pilih Jenis Kelamin"
                                        required>
                                        <option>--Pilih Jenis kelamin--</option>
                                        <option value="L" <?php echo  set_select('jk_siswa', 'laki-laki'); ?>>
                                            Laki-laki</option>
                                        <option value="P" <?php echo  set_select('jk_siswa', 'perempuan'); ?>>
                                            Perempuan</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jabatan"
                                    class="control-label">Jenjang<?php echo form_error('kode_jenjang') ?></label>
                                <div class="input-group">
                                    <?php echo cmb_dinamis('kode_jenjang', 'kode_jenjang', 'jenjang', 'jenjang', 'kode_jenjang', '') ?>
                                    <span class="input-group-addon">
                                        <span class="fas fa-retweet"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kelas" class="control-label">Kelas</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="kelas" id="kelas"
                                        data-error="Kelas harus diisi" placeholder="Kelas"
                                        value="" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d">SIMPAN</button>
                            <a href="<?php echo site_url('kartu/report_kartu') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                                <label for="orangtua" class="control-label">Orang Tua</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="orangtua" id="orangtua"
                                        data-error="Orang Tua harus diisi" placeholder="Nama Orang Tua"
                                        value="" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nik" class="control-label">Status</label>
                                <div class="input-group">
                                <select class="form-control" name="status" class="status">
                                        <option value="0">--Pilih Status--</option>
                                        <option value="1" <?php echo  set_select('status', 'aktif') . (!empty($status) && $status == "Y" ? "selected = 'selected'" : ""); ?>>
                                            Belum diproses</option>
                                        <option value="2" <?php echo  set_select('status', 'tidak aktif'); ?>>
                                            Sedang diproses</option>
                                        <option value="3" <?php echo  set_select('status', 'tidak aktif'); ?>>
                                            Selesai</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->