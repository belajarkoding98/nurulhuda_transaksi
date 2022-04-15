<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?= $box; ?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORMULIR TAMBAH SISWA</h3>
                </div>
                <div class="box-body">
                    <h4>Data Pribadi</h4>
                    <hr>
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nps" class="control-label">NPS (Nomor Pokok Santri)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nps" id="nps"
                                        data-error="Nomor Pokok Santri" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $nps; ?>" required readonly />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-link"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nim" class="control-label">NIM (Nomor Induk Murid)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nim" id="nim"
                                        data-error="Nomor Induk Murid" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $nim; ?>" required readonly />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nisn" class="control-label">NISN (Nomor Induk Siswa
                                    Nasional)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nisn" id="nisn"
                                        data-error="Nomor Induk Siswa Nasional" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $nisn; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nik" class="control-label">NIK (Nomor Induk Kependukukan)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nik" id="nik"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $nik; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nama_siswa" class="control-label">Nama Siswa</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nama_siswa" id="nama_siswa"
                                        data-error="Nama Anggota harus diisi" placeholder="Nama Karyawan"
                                        value="<?php echo $nama_siswa; ?>" required />
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
                                <label for="status"
                                    class="control-label">Status<?php echo form_error('status') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="status" data-error="Nomor Pokok Santri" required>
                                        <option>--Pilih Status--</option>
                                        <option value="Aktif" <?php echo  set_select('status', 'Aktif'); ?>>
                                            Aktif</option>
                                        <option value="Tidak Aktif" <?php echo  set_select('status', 'Tidak Aktif'); ?>>
                                            Tidak Aktif</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir" class="control-label">Tempat Lahir</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                                        data-error="Nomor Pokok Santri" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $tempat_lahir; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                                    data-error="Nomor Pokok Santri" value="<?php echo set_value('tgl_lahir'); ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="agama" class="control-label">Agama<?php echo form_error('agama') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="agama">
                                        <option>--Pilih Agama--</option>
                                        <option value="Islam" <?php echo  set_select('agama', 'Islam'); ?>>
                                            Islam</option>
                                        <option value="Kristen Protestan"
                                            <?php echo  set_select('agama', 'Kristen Protestan'); ?>>
                                            Kristen Protestan</option>
                                        <option value="Kristen Katolik"
                                            <?php echo  set_select('agama', 'Kristen Katolik'); ?>>
                                            Kristen Katolik</option>
                                        <option value="Hindu" <?php echo  set_select('agama', 'Hindu'); ?>>
                                            Hindu</option>
                                        <option value="Buddha" <?php echo  set_select('agama', 'Buddha'); ?>>
                                            Buddha</option>
                                        <option value="Konghucu" <?php echo  set_select('agama', 'Konghucu'); ?>>
                                            Konghucu</option>
                                        <option value="Lainnya" <?php echo  set_select('agama', 'Lainnya'); ?>>
                                            Lainnya</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="negara" class="control-label">Warga
                                    Negara<?php echo form_error('negara') ?></label>
                                <div class="input-group">
                                    <select class="form-control" name="negara">
                                        <option>--Pilih Warga Negara--</option>
                                        <option value="Indonesia" <?php echo  set_select('negara', 'Indonesia'); ?>>
                                            Warga Negara Indonesia</option>
                                        <option value="Asing" <?php echo  set_select('negara', 'Asing'); ?>>
                                            Warga Negara Asing</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hobi</label>
                                <textarea name="hobi" id="" cols="20" rows="1" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Cita-cita</label>
                                <textarea name="cita" id="" cols="20" rows="1" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tk" class="control-label">Pernah TK<?php echo form_error('tk') ?></label>
                                <div class="input-group">
                                    <select class="form-control" name="tk">
                                        <option>--Pilih Jawaban--</option>
                                        <option value="Pernah" <?php echo  set_select('tk', 'Pernah'); ?>>
                                            Pernah</option>
                                        <option value="Tidak" <?php echo  set_select('tk', 'Tidak'); ?>>
                                            Tidak</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="paud" class="control-label">Pernah
                                    PAUD<?php echo form_error('paud') ?></label>
                                <div class="input-group">
                                    <select class="form-control" name="paud">
                                        <option>--Pilih Jawaban--</option>
                                        <option value="Pernah" <?php echo  set_select('paud', 'Pernah'); ?>>
                                            Pernah</option>
                                        <option value="Tidak" <?php echo  set_select('paud', 'Tidak'); ?>>
                                            Tidak</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="exampleInputPassword1">Anak ke</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" name="anak_ke"
                                    value="<?php echo set_value('no_hp'); ?>">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="exampleInputPassword1">Jumlah Saudara</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" name="jml_saudara"
                                    value="<?php echo set_value('no_hp'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tanggal Masuk</label>
                                <input type="date" class="form-control" id="exampleInputPassword1" name="tgl_masuk"
                                    value="<?php echo set_value('tgl_masuk'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Alamat</label>
                                <!-- <input type="date" class="form-control" id="exampleInputPassword1" name="tgl_lahir"
                                    value="<?php echo set_value('alamat'); ?>"> -->
                                <textarea name="alamat" id="" cols="20" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">No HP</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" name="no_hp"
                                    value="<?php echo set_value('no_hp'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="jabatan" class="control-label">Tahun
                                    Masuk<?php echo form_error('jabatan') ?></label>
                                <div class="input-group">
                                    <?php echo cmb_dinamis('tahunajaran', 'tahunajaran', 'tahun_ajaran', 'tahun_ajaran', 'kode_ta', $kode_ta) ?>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jabatan"
                                    class="control-label">Jenjang<?php echo form_error('kode_jenjang') ?></label>
                                <div class="input-group">
                                    <?php echo cmb_dinamis('kode_jenjang', 'kode_jenjang', 'jenjang', 'jenjang', 'kode_jenjang', $kode_jenjang) ?>
                                    <span class="input-group-addon">
                                        <span class="fas fa-retweet"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jabatan"
                                    class="control-label">Kelas<?php echo form_error('kode_kelas') ?></label>
                                <div class="input-group">
                                    <?php echo cmb_dinamis('kode_kelas', 'kode_kelas', 'kelas', 'kode_kelas', 'kode_kelas', $kode_kelas) ?>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('siswa') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class='col-xs-12'>
            <div class="box box-danger collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">DATA ORANG TUA</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action1; ?>"
                        method="post">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="no_kk" class="control-label">Nomor Kartu Keluarga</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_kk" id="no_kk"
                                        data-error="Nomor Kartu Keluarga" placeholder="Nomor Kartu Keluarga"
                                        value="<?php echo $no_kk; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-link"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nama_kk" class="control-label">Nama Kepala Keluarga</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nama_kk" id="nama_kk"
                                        data-error="Nama Kepala Keluarga" placeholder="Nama Kepala Keluarga"
                                        value="<?php echo $nama_kk; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nama_ayah" class="control-label">Nama Ayah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nama_ayah" id="nama_ayah"
                                        data-error="Nomor Induk Siswa Nasional" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $nama_ayah; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir_ayah" class="control-label">Tempat Lahir Ayah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="tempat_lahir_ayah"
                                        id="tempat_lahir_ayah" data-error="Nomor Induk Kependudukan"
                                        placeholder="Nomor Pokok Santri" value="<?php echo $tempat_lahir_ayah; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir_ayah">Tanggal Lahir Ayah</label>
                                <input type="date" class="form-control" id="tgl_lahir_ayah" name="tgl_lahir_ayah"
                                    data-error="Nomor Pokok Santri" value="<?php echo set_value('tgl_lahir_ayah'); ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nik_ayah" class="control-label">NIK (Nomor Induk Kependudukan)
                                    Ayah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nik_ayah" id="nik_ayah"
                                        data-error="Nama Anggota harus diisi" placeholder="Nama Karyawan"
                                        value="<?php echo $nik_ayah; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="status_ayah" class="control-label">Status Ayah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="status_ayah" id="status_ayah"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $status_ayah; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="pendidikan_ayah" class="control-label">Pendidikan Ayah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pendidikan_ayah" id="pendidikan_ayah"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $pendidikan_ayah; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan_ayah" class="control-label">Pekerjaan Ayah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pekerjaan_ayah" id="pekerjaan_ayah"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $pekerjaan_ayah; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="penghasilan_ayah" class="control-label">Penghasilan Ayah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="penghasilan_ayah"
                                        id="penghasilan_ayah" data-error="Nomor Induk Kependudukan"
                                        placeholder="Nomor Pokok Santri" value="<?php echo $penghasilan_ayah; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp_ayah" class="control-label">No HP Ayah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_hp_ayah" id="no_hp_ayah"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $no_hp_ayah; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_ibu" class="control-label">Nama Ibu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nama_ibu" id="nama_ibu"
                                        data-error="Nomor Induk Siswa Nasional" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $nama_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir_ibu" class="control-label">Tempat Lahir Ibu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="tempat_lahir_ibu"
                                        id="tempat_lahir_ibu" data-error="Nomor Induk Kependudukan"
                                        placeholder="Nomor Pokok Santri" value="<?php echo $tempat_lahir_ibu; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir_ibu">Tanggal Lahir Ibu</label>
                                <input type="date" class="form-control" id="tgl_lahir_ibu" name="tgl_lahir_ibu"
                                    data-error="Nomor Pokok Santri" value="<?php echo set_value('tgl_lahir_ibu'); ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nik_ibu" class="control-label">NIK (Nomor Induk Kependudukan)
                                    Ibu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nik_ibu" id="nik_ibu"
                                        data-error="Nama Anggota harus diisi" placeholder="Nama Karyawan"
                                        value="<?php echo $nik_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="status_ibu" class="control-label">Status Ibu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="status_ibu" id="status_ibu"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $status_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="pendidikan_ibu" class="control-label">Pendidikan Ibu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pendidikan_ibu" id="pendidikan_ibu"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $pendidikan_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan_ibu" class="control-label">Pekerjaan Ibu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pekerjaan_ibu" id="pekerjaan_ibu"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $pekerjaan_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="penghasilan_ibu" class="control-label">Penghasilan Ibu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="penghasilan_ibu" id="penghasilan_ibu"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $penghasilan_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp_ibu" class="control-label">No HP Ibu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_hp_ibu" id="no_hp_ibu"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $no_hp_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Alamat</label>
                                <!-- <input type="date" class="form-control" id="exampleInputPassword1" name="tgl_lahir"
            value="<?php echo set_value('alamat'); ?>"> -->
                                <textarea name="alamat" id="" cols="20" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="provinsi"
                                    class="control-label">Provinsi<?php echo form_error('provinsi') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="provinsi" data-error="Pilih Provinsi" required>
                                        <option>--Pilih Jenis kelamin--</option>
                                        <option value="L" <?php echo  set_select('provinsi', 'laki-laki'); ?>>
                                            Laki-laki</option>
                                        <option value="P" <?php echo  set_select('provinsi', 'perempuan'); ?>>
                                            Perempuan</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="provinsi"
                                    class="control-label">Kabupaten<?php echo form_error('provinsi') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="provinsi" data-error="Pilih Provinsi" required>
                                        <option>--Pilih Jenis kelamin--</option>
                                        <option value="L" <?php echo  set_select('provinsi', 'laki-laki'); ?>>
                                            Laki-laki</option>
                                        <option value="P" <?php echo  set_select('provinsi', 'perempuan'); ?>>
                                            Perempuan</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="provinsi"
                                    class="control-label">Kelurahan<?php echo form_error('provinsi') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="provinsi" data-error="Pilih Provinsi" required>
                                        <option>--Pilih Jenis kelamin--</option>
                                        <option value="L" <?php echo  set_select('provinsi', 'laki-laki'); ?>>
                                            Laki-laki</option>
                                        <option value="P" <?php echo  set_select('provinsi', 'perempuan'); ?>>
                                            Perempuan</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp_ibu" class="control-label">Kode POS</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_hp_ibu" id="no_hp_ibu"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $no_hp_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp_ibu" class="control-label">Koordinat Lintang</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_hp_ibu" id="no_hp_ibu"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $no_hp_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp_ibu" class="control-label">Koordinat Bujur</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_hp_ibu" id="no_hp_ibu"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $no_hp_ibu; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('siswa') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col -->

        <div class='col-xs-12'>
            <div class="box box-danger collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">DATA TEMPAT TINGGAL SISWA</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action2; ?>"
                        method="post">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="jenis_tempat_tinggal" class="control-label">Jenis tempat tinggal</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="jenis_tempat_tinggal"
                                        id="jenis_tempat_tinggal" data-error="Nomor Induk Kependudukan"
                                        placeholder="Nomor Pokok Santri" value="<?php echo $jenis_tempat_tinggal; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Alamat</label>
                                <!-- <input type="date" class="form-control" id="exampleInputPassword1" name="tgl_lahir"
            value="<?php echo set_value('alamat'); ?>"> -->
                                <textarea name="alamat" id="" cols="20" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="provinsi"
                                    class="control-label">Provinsi<?php echo form_error('provinsi') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="provinsi" data-error="Pilih Provinsi" required>
                                        <option>--Pilih Jenis kelamin--</option>
                                        <option value="L" <?php echo  set_select('provinsi', 'laki-laki'); ?>>
                                            Laki-laki</option>
                                        <option value="P" <?php echo  set_select('provinsi', 'perempuan'); ?>>
                                            Perempuan</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kabupaten"
                                    class="control-label">Kabupaten<?php echo form_error('kabupaten') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="kabupaten" data-error="Pilih kabupaten" required>
                                        <option>--Pilih Jenis kelamin--</option>
                                        <option value="L" <?php echo  set_select('kabupaten', 'laki-laki'); ?>>
                                            Laki-laki</option>
                                        <option value="P" <?php echo  set_select('kabupaten', 'perempuan'); ?>>
                                            Perempuan</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kecamatan"
                                    class="control-label">kecamatan<?php echo form_error('kecamatan') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="kecamatan" data-error="Pilih kecamatan" required>
                                        <option>--Pilih Jenis kelamin--</option>
                                        <option value="L" <?php echo  set_select('kecamatan', 'laki-laki'); ?>>
                                            Laki-laki</option>
                                        <option value="P" <?php echo  set_select('kecamatan', 'perempuan'); ?>>
                                            Perempuan</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kelurahan"
                                    class="control-label">Kelurahan<?php echo form_error('kelurahan') ?></label>
                                <div class="input-group">
                                    <!-- <php echo cmb_dinamis('jabatan', 'jabatan', 'jabatan', 'nama_jabatan', 'id_jabatan', $jabatan) ?> -->
                                    <select class="form-control" name="kelurahan" data-error="Pilih kelurahan" required>
                                        <option>--Pilih Jenis kelamin--</option>
                                        <option value="L" <?php echo  set_select('kelurahan', 'laki-laki'); ?>>
                                            Laki-laki</option>
                                        <option value="P" <?php echo  set_select('kelurahan', 'perempuan'); ?>>
                                            Perempuan</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kode_pos" class="control-label">Kode POS</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="kode_pos" id="kode_pos"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $kode_pos; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="jarak_ke_sekolah" class="control-label">Jarak Sekolah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="jarak_ke_sekolah"
                                        id="jarak_ke_sekolah" data-error="Nomor Induk Kependudukan"
                                        placeholder="Nomor Pokok Santri" value="<?php echo $jarak_ke_sekolah; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="transportasi" class="control-label">Transportasi</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="transportasi" id="transportasi"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $transportasi; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="koor_lintang_sekolah" class="control-label">Koordinat Lintang</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="koor_lintang_sekolah"
                                        id="koor_lintang_sekolah" data-error="Nomor Induk Kependudukan"
                                        placeholder="Nomor Pokok Santri" value="<?php echo $koor_lintang_sekolah; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="koor_bujur_sekolah" class="control-label">Koordinat Bujur</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="koor_bujur_sekolah"
                                        id="koor_bujur_sekolah" data-error="Nomor Induk Kependudukan"
                                        placeholder="Nomor Pokok Santri" value="<?php echo $koor_bujur_sekolah; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <div class="box-footer">
                                <button type="submit"
                                    class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                                <a href="<?php echo site_url('siswa') ?>"
                                    class="btn btn-default btn-lg btn3d">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class='col-xs-12'>
            <div class="box box-danger collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">DATA SEKOLAH SEBELUMNYA</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action3; ?>"
                        method="post">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="jenjang_sekolah_sblm" class="control-label">Jenjang</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="jenjang_sekolah_sblm"
                                        id="jenjang_sekolah_sblm" data-error="Jenjang Sekolah Sebelumnya"
                                        placeholder="Jenjang Sekolah Sebelumnya"
                                        value="<?php echo $jenjang_sekolah_sblm; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="status_sekolah_sblm" class="control-label">Status Sekolah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="status_sekolah_sblm"
                                        id="status_sekolah_sblm" data-error="Status Sekolah Sebelumnya"
                                        placeholder="Status Sekolah Sebelumnya"
                                        value="<?php echo $status_sekolah_sblm; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="npsn" class="control-label">NPSN</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="npsn" id="npsn" data-error="npsn"
                                        placeholder="npsn" value="<?php echo $npsn; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nama_sekolah" class="control-label">Nama Sekolah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $nama_sekolah; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="lokasi_sekolah" class="control-label">Lokasi Sekolah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="lokasi_sekolah" id="lokasi_sekolah"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $lokasi_sekolah; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="no_peserta_un" class="control-label">No Peserta UN</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_peserta_un" id="no_peserta_un"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $no_peserta_un; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="no_skhun" class="control-label">No SKHUN</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_skhun" id="no_skhun"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $no_skhun; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="no_ijasah" class="control-label">No Ijasah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_ijasah" id="no_ijasah"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $no_ijasah; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="total_nilai" class="control-label">Total Nilai</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="total_nilai" id="total_nilai"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $total_nilai; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="tahun_ajaran" class="control-label">Tahun Ajaran</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran"
                                        data-error="Nomor Induk Kependudukan" placeholder="Nomor Pokok Santri"
                                        value="<?php echo $tahun_ajaran; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>


                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <div class="box-footer">
                                <button type="submit"
                                    class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                                <a href="<?php echo site_url('siswa') ?>"
                                    class="btn btn-default btn-lg btn3d">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class='col-xs-12'>
            <div class="box box-danger collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">DATA BANTUAN SISWA</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action4; ?>"
                        method="post">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="no_kip" class="control-label">No KIP</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_kip" id="no_kip"
                                        data-error="Nomor Kartu Indonesia Pintar"
                                        placeholder="Nomor Kartu Indonesia Pintar" value="<?php echo $no_kip; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="no_pkh" class="control-label">No PKH</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_pkh" id="no_pkh"
                                        data-error="Nomor PKH" placeholder="Nomor PKH" value="<?php echo $no_pkh; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <div class="box-footer">
                                <button type="submit"
                                    class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                                <a href="<?php echo site_url('siswa') ?>"
                                    class="btn btn-default btn-lg btn3d">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class='col-xs-12'>
            <div class="box box-danger collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">DATA KESEHATAN</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action5; ?>"
                        method="post">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tinggi" class="control-label">Tinggi</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="tinggi" id="tinggi"
                                        data-error="Tinggi" placeholder="Tinggi dalam cm" value="<?php echo $tinggi; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="bb" class="control-label">Berat Badan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="bb" id="bb" data-error="Berat Badan"
                                        placeholder="Berat Badan dalam cm" value="<?php echo $bb; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="ling_kepala" class="control-label">Lingkar Kepala</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="ling_kepala" id="ling_kepala"
                                        data-error="Lingkar Kepala" placeholder="Lingkar Kepala"
                                        value="<?php echo $ling_kepala; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="hepa_b" class="control-label">Hepatitis B</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="hepa_b" id="hepa_b"
                                        data-error="Hepatitis B" placeholder="Hepatitis B"
                                        value="<?php echo $hepa_b; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="polio" class="control-label">Polio</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="polio" id="polio" data-error="Polio"
                                        placeholder="Polio" value="<?php echo $polio; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="campak" class="control-label">Campak</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="campak" id="campak"
                                        data-error="Campak" placeholder="Campak" value="<?php echo $campak; ?>"
                                        required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <div class="box-footer">
                                <button type="submit"
                                    class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                                <a href="<?php echo site_url('siswa') ?>"
                                    class="btn btn-default btn-lg btn3d">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.row -->
</section><!-- /.content -->