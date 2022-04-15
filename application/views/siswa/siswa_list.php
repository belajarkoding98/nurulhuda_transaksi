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

.DTFC_RightBodyLiner {
    overflow-x: hidden;
}
</style>
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-primary'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>DATA SISWA</h3>
                    <div class="pull-right">
                        <?php echo anchor(site_url('import_siswa'), ' <i class="fa fa-file-upload"></i> &nbsp;&nbsp; Import Data', ' class="btn btn-success btn-lg btn-create-data btn3d" hidden="true"'); ?>
                        <?php echo anchor(site_url('tambah_siswa'), ' <i class="fa fa-plus"></i> &nbsp;&nbsp; Tambah Baru', ' class="btn btn-unique btn-lg btn-create-data btn3d" hidden="true"'); ?>
                    </div>
                </div>
                <div class="box-body">
                    <div class="actionPart">
                        <div class="actionSelect">
                            <div class="col-md-3">
                                <select id="exportLink" class="form-control">
                                    <option>Pilih Metode Ekspor Data</option>
                                    <option id="csv">Ekspor menjadi CSV</option>
                                    <option id="excel">Ekspor menjadi Excel</option>
                                    <option id="print">Cetak Data</option>
                                    <option id="pdf">Ekspor menjadi PDF</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <table id="mytable" class="table table-bordered table-hover display" style="width:100%;">
                        <!-- <table id="mytable" class="stripe row-border order-column" style="width:100%"> -->
                        <thead>
                            <tr>
                                <th class="all">No.</th>
                                <th class="all">NPS</th>
                                <th class="all">Nama Siswa</th>
                                <th class="all">Jenis Kelamin</th>
                                <th class="all">Status</th>
                                <th class="all">Tempat</th>
                                <th class="all">Tanggal Lahir</th>
                                <th class="all">Tahun Pelajaran</th>
                                <th class="all">Jenjang</th>
                                <th class="all">Kelas</th>
                                <th class="all">Nama Ayah</th>
                                <th class="all">No HP Ayah</th>
                                <th class="all">Nama Ibu</th>
                                <th class="all">No HP Ibu</th>
                                <th class="all">Alamat</th>
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
</script>
<script src="<?php echo base_url("assets/app/datatables/siswa.js") ?>" charset="utf-8"></script>
<!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" charset="utf-8"> -->
<!-- </script> -->