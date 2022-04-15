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
<link href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css" rel="stylesheet" />

<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-primary'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>Laporan Transaksi jajan</h3>
                    <div class="pull-right">
                    </div>
                </div>
                <h4>Saldo <span id="saldo">Rp. 0</span></h4>
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
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Total Bayar</th>
                                <th>Jumlah Uang</th>
                                <th>Diskon</th>
                                <th>NPS</th>
                                <th>Pelanggan</th>
                                <th>Pembeli</th>
                                <th>Kantin/Toko</th>
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
    let readUrl = '<?= site_url('transaksi/read') ?>';
    let checkLogin = '<?= $result ?>';
    let Tanggal = '<?= Date('d-m-Y') ?>';

    function LoadDate(id) {
        var start = $('#start').val();
        var end = $('#end').val();
        var id_shift = $('#id_shift').val();
        var url = "rekap/ajax_list_modal2/<?php echo $this->uri->segment(3); ?>/";
        $.ajax({
            url: url,
            type: "GET",
            data: {
                start: start,
                end: end,
                id_shift: id_shift,
            },
            datatype: 'text',
            success: function(data) {
                $('#datakar').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
            }
        });
    }
</script>

<script src="<?php echo base_url() ?>assets/app/datatables/laporan_transaksi.js" charset="utf-8"></script>
<!-- <script src="<?php echo base_url() ?>assets/app/core/modalLaporanTransaksi.js" charset="utf-8"></script> -->
<script src="https://code.jquery.com/jquery-3.5.1.js" charset="utf-8"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js" charset="utf-8"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js" charset="utf-8"></script>