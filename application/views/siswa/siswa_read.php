<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class="box box-success">
                <div class='box-header with-border'>
                    <h3 class='box-title'>Detail Siswa</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>NPS (Nomor Pokok Santri)</td>
                            <td><?php echo $nps; ?></td>
                        </tr>
                        <tr>
                            <td>NIM (Nomor Induk Murid)</td>
                            <td><?php echo $nim; ?></td>
                        </tr>
                        <tr>
                            <td>NISN (Nomor Induk Siswa Nasional)</td>
                            <td><?php echo $nisn; ?></td>
                        </tr>
                        <tr>
                            <td>NIK (Nomor Induk Kependudukan)</td>
                            <td><?php echo $nik; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Siswa</td>
                            <td><?php echo $nama_siswa; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td><?php echo $jk; ?></td>
                        </tr>
                        <tr>
                            <td>Tempat, Tanggal Lahir</td>
                            <td><?php echo $tempat . $tgl_lahir; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><?php echo $alamat; ?></td>
                        </tr>
                        <tr>
                            <td>No_HP</td>
                            <td><?php echo $no_hp; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;"><a href="<?php echo site_url('siswa') ?>"
                                    class="btn-xs btn btn-primary">Kembali</a></td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->
</section><!-- /.content -->