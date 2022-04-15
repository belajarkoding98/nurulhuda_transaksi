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
    <!-- <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
            <div class='box-header  with-border'>
                    <h3 class='box-title'>Cari Data Berdasarkan Kelas</h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-6">
                        <form action="">
                        <div class="form-group">
                                    <div class="input-group">
                                        <?php echo cmb_dinamis('kode_kelas', 'kode_kelas', 'kelas', 'kode_kelas', 'kode_kelas', 'kode_kelas') ?>
                                        <span class="input-group-addon">
                                            <span class="fas fa-school"></span>
                                        </span>
                                    </div>
                                    <input type="button" id="carikelas" value="SUBMIT">
                                    <div class="help-block with-errors"></div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-primary'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>DATA Kehilangan Kartu</h3>
                    <div class="pull-right">
                    <?php echo anchor(site_url('tambah_nasabah'), ' <i class="fa fa-plus"></i> &nbsp;&nbsp; Tambah Baru', ' class="btn btn-unique btn-lg btn-create-data btn3d" hidden="true"'); ?>
                    </div>
                        <!-- <php echo anchor(site_url('import_saldo'), ' <i class="fa fa-dollar"></i> &nbsp;&nbsp; Import Saldo', ' class="btn btn-warning btn-lg btn-create-data btn3d" id="importsaldo" hidden="true"'); ?> -->
                        <!-- <php echo anchor(site_url('import_nasabah'), ' <i class="fa fa-file-upload"></i> &nbsp;&nbsp; Import Data', ' class="btn btn-success btn-lg btn-create-data btn3d" hidden="true"'); ?> -->
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
                    </div>
                    <table id="mytable" class="table table-bordered table-hover display" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="all">No.</th>
                                <th class="all">Tanggal</th>
                                <th class="all">NPS</th>
                                <th class="all">Nama Siswa</th>
                                <th class="all">Kelas</th>
                                <th class="all">Orang Tua</th>
                                <th class="all">Status</th>
                                <th class="desktop">action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="7" style="text-align:right">Total:</th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->

<?php
// var_dump($kartu_data);
foreach ($kartu_data as $i) :
    $id = $i->id;
    $nps = $i->nps;
?>
    <div class="modal" id="modal_status<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Status <?= $i->nama_siswa ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?= base_url('/kartu/update_kartu') ?>" method="post">
                        <input type="hidden" class="form-control" name="id" id="nps" placeholder=" Masukan nominal saldo" value="<?= $id ?>" />
                        <select class="form-control" name="status" class="status">
                                        <option value="0">--Pilih Status--</option>
                                        <option value="1" <?php echo  set_select('status', 'aktif') . (!empty($status) && $status == "Y" ? "selected = 'selected'" : ""); ?>>
                                            Belum diproses</option>
                                        <option value="2" <?php echo  set_select('status', 'tidak aktif'); ?>>
                                            Sedang diproses</option>
                                        <option value="3" <?php echo  set_select('status', 'tidak aktif'); ?>>
                                            Selesai</option>
                                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
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

    $(document).ready(function(){
        $(':input[type="submit"]').prop('disabled', true);
        $('select[name="status"]').on('change', function(){
            if($(this).val() == "0"){
                $(':input[type="submit"]').prop('disabled', true);
            }else{
                $(':input[type="submit"]').prop('disabled', false);
            }
        });
    });
</script>
<!-- <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> -->

    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/app/datatables/kartu.js" charset="utf-8"></script>