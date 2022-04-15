<body class="hold-transition skin-blue layout-top-nav" onLoad="pindah()">

    <div class="container">
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">PENJUALAN</h3>
                        </div>
                        <div class="box-body">
                            <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>"
                                method="post">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nama_karyawan" class="control-label">NOMOR POKOK SANTRI</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nps" id="nps"
                                                data-error="Masukan Tahun Ajaran" placeholder="Nomor Pokok Santri"
                                                value="<?php echo $nps; ?>" required autofocus="autofocus" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                            </span>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_karyawan" class="control-label">MASUKAN NOMINAL DISINI</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nominal" id="ahunajaran"
                                                data-error="Masukan Tahun Ajaran" placeholder="Tahun Nominal"
                                                value="<?php echo $nominal; ?>" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                            </span>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit"
                                            class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                                        <a href="<?php echo site_url('transaksi') ?>"
                                            class="btn btn-default btn-lg btn3d">Cancel</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                </div>
                            </form>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jQueryUI/css/jquery-ui.css">
    <script src="<?php echo base_url() ?>assets/plugins/jQueryUI/js/jquery-ui.js"></script>

    <script type="text/javascript">
    function pindah() {
        $('#id').focus();
    };

    function ready() {
        var id = $('#id').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('/GenBar/showw') ?>',
            data: `id=${id}`,
            beforeSend: function(msg) {
                $('#showR').html('<h1><i class="fa fa-spin fa-refresh" /></h1>');
            },
            success: function(msg) {
                $('#showR').html(msg);
                $('#id_karyawan').focus();
            }
        });
    }
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#id').autocomplete({
            source: "<?php echo site_url('GenBar/get_autocomplete'); ?>",
            select: function(event, ui) {
                $('[name="qr"]').val(ui.item.label);
            }
        });
    });
    </script>
</body>

</html>