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
                    <h3 class='box-title'>Transaksi <?= $nasabah ?></h3>
                    <div class="pull-right">
                        <!-- <php echo anchor(site_url('import_nasabah'), ' <i class="fa fa-file-upload"></i> &nbsp;&nbsp; Import Data', ' class="btn btn-success btn-lg btn-create-data btn3d" hidden="true"'); ?> -->
                        <?php echo anchor(site_url('nasabah'), ' <i class="fa fa-backspace"></i> &nbsp;&nbsp; Kembali', ' class="btn btn-primary btn-lg btn-create-data btn3d" hidden="true"'); ?>
                    </div>
                </div>
                <div class="box-body">
                    <?php echo anchor(site_url('setoran_nasabah/') . $nps, ' <i class="fa fa-file-download fa-2x"></i> &nbsp;&nbsp; Setoran Tunai', ' class="btn btn-success btn-lg btn-create-data btn3d" hidden="true"'); ?>
                    <?php echo anchor(site_url('penarikan_nasabah/') . $nps, ' <i class="fa fa-file-upload fa-2x"></i> &nbsp;&nbsp; Penarikan Tunai', ' class="btn btn-danger btn-lg btn-create-data btn3d" id="tariktunai" hidden="true"'); ?>
                    <div class="pull-right">
                        <h3>Saldo <span id="saldo">Rp. <?= rupiah($saldo) ?></span></h3>
                    </div>
                </div>

                <div class="box-body">
                    <div class="actionPart">
                        <div class="actionSelect">
                            <div class="col-md-3">
                                <select id="exportLink" class="form-control">
                                    <option>Pilih Metode Ekspor Data</option>
                                    <option id="print">Cetak Data</option>
                                    <option id="excel">Ekspor Menjadi Excel</option>
                                    <option id="pdf">Ekspor menjadi PDF</option>
                                    <option id="csv">Ekspor menjadi CSV</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <table id="mytable" class="table table-bordered table-hover display" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="all">No.</th>
                                <th class="all">Tipe.</th>
                                <th class="all">Tanggal</th>
                                <th class="all">No Transaksi</th>
                                <th class="all">ID Nasabah</th>
                                <th class="all">NPS</th>
                                <th class="all">Kredit</th>
                                <th class="all">Debit</th>
                                <th class="all">Saldo</th>
                                <th class="all">Keperluan</th>
                                <th class="all">Keterangan</th>
                                <th class="desktop">action</th>
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
    let UriSegment = '<?php echo $this->uri->segment(2) ?>';
    let NamaNasabah = "<?php echo $nasabah ?>";
    // alert(UriSegment);
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



    //disable tombol tarik tunai jika saldo 0
</script>
<script src="<?php echo base_url() ?>assets/app/datatables/nasabah_detail.js" charset="utf-8"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" charset="utf-8"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js" charset="utf-8"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js" charset="utf-8"></script>

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