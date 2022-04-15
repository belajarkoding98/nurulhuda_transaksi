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
</style>
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-primary'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>Laporan Cukur</h3>
                    <div class="pull-right">
                        <!-- <php echo anchor(site_url('import_saldo'), ' <i class="fa fa-dollar"></i> &nbsp;&nbsp; Import Saldo', ' class="btn btn-warning btn-lg btn-create-data btn3d" id="importsaldo" hidden="true"'); ?> -->
                    </div>
                </div>
                <div class="box-body">
                    <div class="actionPart">
                        <div class="actionSelect">
                            <div class="col-md-3">
                                <select id="exportLink" class="form-control">
                                    <option>Pilih Metode Ekspor Data</option>
                                    <option id="print">Cetak Data</option>
                                    <option id="copy">Copy Data</option>
                                    <option id="excel">Ekspor Menjadi Excel</option>
                                    <option id="pdf">Ekspor menjadi PDF</option>
                                    <option id="csv">Ekspor menjadi CSV</option>
                                </select>
                            </div>
                        </div>
                        <div class="pull-right">
                    <h4>Saldo <span id="saldo">Rp. 0</span></h4>
                        </div>
                    </div>
                    <table id="mytable" class="table table-bordered table-hover display" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="all">No.</th>
                                <th class="all">Tanggal</th>
                                <th class="all">No Transaksi</th>
                                <th class="all">NPS</th>
                                <th class="all">Nama</th>
                                <th class="all">Biaya Cukur</th>
                                <th class="all">Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->

<script type="text/javascript">
    let base_url = '<?= base_url() ?>';
</script>
<script type="text/javascript">
    let checkLogin = '<?= $result ?>';
    let Tanggal = '<?= Date('d-m-Y') ?>';
</script>
<script type="text/javascript">
    $(function() {
        $('#btn-topup').click(function(e) {
            e.preventDefault();
            $('#modal').modal({
                backdrop: 'static',
                show: true
            });
            id = $(this).data('id');
            // mengambil nilai data-id yang di click
            $.ajax({
                url: 'nasabah/edit_modal/' + id,
                success: function(data) {
                    $("#nps").val(data.id);
                }
            });
        });
    });
</script>
<script src="<?php echo base_url() ?>assets/app/datatables/cukur.js" charset="utf-8"></script>