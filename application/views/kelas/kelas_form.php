<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?= $box; ?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORMULIR TAMBAH KELAS</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="jabatan" class="control-label">Jenjang<?php echo form_error('kode_jenjang') ?></label>
                            <div class="input-group">
                                <select class="form-control" name="kode_jenjang" id="kode_jenjang">
                                    <option>--Pilih Kelas--</option>
                                    <?php
                                    foreach ($kode_jenjang as $jenjang) { ?>
                                        <option value="<?= $jenjang->kode_jenjang ?>"><?= $jenjang->jenjang  ?></option>
                                    <?php } ?>
                                    ?>
                                </select>
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gedung_id" class="control-label">Kelas<?php echo form_error('kelas') ?></label>
                            <div class="input-group">
                                <select class="form-control" name="kelas" id="kode_kelas">
                                    <option>--Pilih Kelas--</option>
                                </select>
                                <span class="input-group-addon">
                                    <span class="fas fa-location-arrow"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_shift" class="control-label">Nama
                                Kelas<?php echo form_error('nm_kelas') ?></label>
                            <div class="input-group">
                                <select name="nm_kelas" class="form-control">
                                    <option value="">--Pilih Nama Kelas--</option>
                                    <?php
                                    foreach (range('A', 'F') as $char) { ?>
                                        <option value="<?= $char ?>"><?= $char  ?></option>
                                    <?php } ?>
                                </select>
                                <span class="input-group-addon">
                                    <span class="fas fa-retweet"></span>
                                </span>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('kelas') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->

<script>
    $('#kode_jenjang').on('change', function() {
        var kode_jenjang = $(this).val();
        // alert(kode_jenjang)
        if (kode_jenjang == "SDIT") {
            var kelas = ["I", "II", "III", "IV", "V", "VI"];
        } else if (kode_jenjang == "SMPIT") {
            var kelas = ["VII", "VIII", "IX"];
        } else if (kode_jenjang == "MA") {
            var kelas = ["X", "XI", "XII"];
        }

        for (var i = 0; i < kelas.length; i++) {
            $('<option/>').val(kelas[i]).html(kelas[i]).appendTo('#kode_kelas');
        }
    });
</script>