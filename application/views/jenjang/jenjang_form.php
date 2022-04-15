<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?= $box; ?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORMULIR TAMBAH JENJANG</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_karyawan" class="control-label">Kode Jenjang</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="kode_jenjang" id="kode_jenjang"
                                        data-error="Masukan Kode Jenjang" placeholder="Kode Jenjang"
                                        value="<?php echo $kode_jenjang; ?>" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="nama_karyawan" class="control-label">Nama Jenjang</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nama_jenjang" id="nama_jenjang"
                                        data-error="Masukan Nama Jenjang" placeholder="Nama Jenjang"
                                        value="<?php echo $nama_jenjang; ?>" required />
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
                                <a href="<?php echo site_url('jenjang') ?>"
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