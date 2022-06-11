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
                    <h3 class='box-title'>DATA Nasabah</h3>
                    <div class="pull-right">
                    <?php echo anchor(site_url('tambah_nasabah'), ' <i class="fa fa-plus"></i> &nbsp;&nbsp; Tambah Baru', ' class="btn btn-unique btn-lg btn-create-data btn3d" hidden="true"'); ?>
                    </div>
                    <div class="pull-right" style="margin-top: 5px; margin-right: 5px;">
                    <select class="form-control" name="status" onchange="location = this.value;">
                        <option value="nasabah">-- PILIH IMPORT --</option>
                        <option value="import_nasabah">
                            IMPORT DATA</option>
                        <option value="nasabah/import_setoran">
                            IMPORT SETORAN</option>
                        <option value="import_saldo">
                            IMPORT SALDO</option>
                        <option value="nasabah/import_kas_galon">
                            IMPORT KAS & GALON</option>
                        <option value="nasabah/import_lainnya">
                            IMPORT LAINNYA</option>
                    </select>
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
                                <th class="all">ID Nasabah</th>
                                <th class="all">NPS</th>
                                <th class="all">Nama</th>
                                <th class="all">Orang Tua</th>
                                <th class="all">Kelas</th>
                                <th class="all">Saldo Utama</th>
                                <th class="all">Saldo Sementara</th>
                                <th class="all">Pengeluaran</th>
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
// var_dump($nasabah_data);
foreach ($nasabah_data as $i) :
    $id = $i->id;
    $nps = $i->nps;
    $saldo = $i->saldo;
?>
    <div class="modal" id="modal_edit<?= $nps ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Topup </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?= base_url('/topup_nasabah') ?>" method="post">
                        <div class="form-group">
                            <label for="nama_karyawan" class="control-label">NPS</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="nps" id="nps" data-error="Masukan Nominal Saldo" placeholder=" Masukan nominal saldo" value="<?= $nps ?>" required readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="nama_karyawan" class="control-label">Saldo Sebelumnya</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="saldosebelumnya" id="saldo" data-error="Masukan Nominal Saldo" placeholder="Masukan nominal saldo" value="<?= $saldo ?>" required readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="nama_karyawan" class="control-label">Saldo Ditambahkan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="saldoditambah" id="saldo" data-error="Masukan Nominal Saldo" placeholder="Masukan nominal saldo" value="" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
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
    //    var kode_kelas = $("#kode_kelas").val();
    //    let kode_kelas;
    // //    if(kode_kelas == 'VIII-5-A'){
    // //    }
    //    alert(kode_kelas);
    //    $('#carikelas').on('click', function(){
    //        var k_kelas = $("#kode_kelas").val();
    //        if(k_kelas){
    //            let kode_kelas = k_kelas;
    //            alert(kode_kelas);
    //     }
    //     });
    });
    //     function fetch_data(kode_kelas){
    //         var dataTable =  $('#myTable').DataTable({
    //             processing : true,
    //             serverSide : true,
    //             order : [],
    //             oLanguage: {
    //             sProcessing: "loading..."
    //         },
    //         lengthMenu: [
    //             [10, 25, 50, -1],
    //             ['10', '25', '50', 'Show all']
    //         ],
    //         "order": [
    //             [1, 'desc']
    //         ],
    //         ajax: {
    //             "url": base_url + "nasabah/carikelas",
    //             "type": "POST",
    //             "data": {
    //                 id: kode_kelas
    //             }
    //         },
    //             });
    //         }
    // });
</script>
<!-- <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> -->

    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/app/datatables/nasabah.js" charset="utf-8"></script>