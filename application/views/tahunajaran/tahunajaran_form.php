<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?= $box; ?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORMULIR TAMBAH Tahun Ajaran</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_karyawan" class="control-label">Tahun Ajaran</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="tahunajaran" id="ahunajaran"
                                        data-error="Masukan Tahun Ajaran" placeholder="Tahun Ajaran"
                                        value="<?php echo $tahunajaran; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
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
                                        <option value="aktif" <?php echo  set_select('status', 'aktif'); ?>>
                                            Aktif</option>
                                        <option value="tidak aktif" <?php echo  set_select('status', 'tidak aktif'); ?>>
                                            Tidak Aktif</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <span class="fas fa-briefcase"></span>
                                    </span>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <div class="box-footer">
                                <button type="submit"
                                    class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                                <a href="<?php echo site_url('tahunajaran') ?>"
                                    class="btn btn-default btn-lg btn3d">Cancel</a>
                            </div>
                        </div>
                        <div class="col-lg-6">

                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->