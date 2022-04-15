<body class="hold-transition skin-blue layout-top-nav" onLoad="pindah()">

    <div class="container">
        <section class="content">
            <div class="row">
                <div class="col-md-10">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">UPLOAD FILE EXCEL SALDO</h3>
                        </div>
                        <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
                        <form method="post" action="<?= base_url('nasabah/form_import'); ?>" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">IMPORT FILE EXCEL DI SINI</label>
                                    <input class="form-control" type="file" name="file">
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary btn-lg btn3d" name="preview" value="Preview">
                            </div>
                        </form>


                    </div>

                </div>
                <div class="col-md-10">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">INFORMASI PREVIEW AKAN MUNCUL DISINI</h3>
                        </div>
                        <div class="box-body ajax-content" id="showR">
                            <?php
                            if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
                                if (isset($upload_error)) { // Jika proses upload gagal
                                    echo "<div style='color: red;'>" . $upload_error . "</div>"; // Muncul pesan error upload
                                    die; // stop skrip
                                }

                                // Buat sebuah tag form untuk proses import data ke database
                                echo "<form method='post' action='" . site_url("nasabah/import_data_saldo") . "'>";

                                echo "<input type='hidden' name='namafile' value='" . $nama_file_baru . "'>";


                                // Buat sebuah div untuk alert validasi kosong
                                echo "<div class='form-group'><div style='color: red;' id='buttonImport'>
                                </div></div>";
                                echo "<div style='color: red;' id='kosong'>
                                    </div>";


                                echo "<div class='form-group'><table class='table table-striped' border='1' cellpadding='8'>
                                <thead>
		<tr>
			<th colspan='9'>Preview Data Saldo</th>
		</tr>
		<tr>
        <th class='all'>No.</th>
        <th class='all'>ID Nasabah</th>
        <th class='all'>NPS</th>
        <th class='all'>Nama</th>
        <th class='all'>Kelas</th>
        <th class='all'>Saldo Sementara</th>
		</tr></thead>";

        $numrow = 1;
            $kosong = 0;
                                // Lakukan perulangan dari data yang ada di excel
                                // $sheet adalah variabel yang dikirim dari controller
                                foreach ($sheet as $row) {
                                    // Ambil data pada excel sesuai Kolom
                                    $no = $row['A']; // Ambil data no
                                    $id_nasabah = $row['B']; // Ambil data NPS
                                    $nps = $row['C']; // Ambil data NPS
                                    $nama = $row['D']; // Ambil data NAMA
                                    $kelas = $row['E']; // Ambil data NAMA
                                    $saldo_sementara = $row['F']; // Ambil data Saldo Sementara

                                    // Cek jika semua data tidak diisi
                                    if ($no == null && $id_nasabah == null && $nps == null && $nama == null && $kelas == null && $saldo_sementara == null)
                                        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                                    // Cek $numrow apakah lebih dari 1
                                    // Artinya karena baris pertama adalah nama-nama kolom
                                    // Jadi dilewat saja, tidak usah diimport
                                    if ($numrow > 1) {
                                        // Validasi apakah semua data telah diisi
                                        $no_td = (!empty($no)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                        $id_nasabah_td = (!empty($id_nasabah)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $nps_td = (!empty($nps)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $nama_td = (!empty($nama)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $kelas_td = (!empty($kelas)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $saldo_sementara_td = ($saldo_sementara >= 0) ? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah

                                        // Jika salah satu data ada yang kosong
                                        if ($no == null or $id_nasabah == null or $nps == null or $nama == null or $kelas == null) {
                                            $kosong = 1; // Tambah 1 variabel $kosong
                                        }

                                        echo "<tr>";
                                        echo "<td" . $no_td . ">" . $no . "</td>";
                                        echo "<td" . $id_nasabah_td . ">" . $id_nasabah . "</td>";
                                        echo "<td" . $nps_td . ">" . $nps . "</td>";
                                        echo "<td" . $nama_td . ">" . $nama . "</td>";
                                        echo "<td" . $kelas_td . ">" . $kelas . "</td>";
                                        echo "<td" . $saldo_sementara_td . ">" . $saldo_sementara . "</td>";
                                        echo "</tr>";
                                    }

                                    $numrow++; // Tambah 1 setiap kali looping
                                }

                                echo "</table></div>";

                                // Cek apakah variabel kosong lebih dari 0
                                // Jika lebih dari 0, berarti ada data yang masih kosong
                                if ($kosong > 0) {
                            ?>
                                    <script>
                                        $(document).ready(function() {
                                            // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                                            $("#kosong").html(
                                                'Semua data belum diisi, Ada <?php echo $kosong; ?> data yang belum diisi.'
                                            );

                                            // $("#kosong").show(); // Munculkan alert validasi kosong
                                        });
                                    </script>
                            <?php
            } else { // Jika semua data sudah diisi
                echo "<hr>";

                ?>
                <script>
                    $(document).ready(function() {
                    $("#buttonImport").html("<button class='btn btn-success btn-lg' type='submit' name='import'>Import</button>");
                });
                </script>
                <?php
                // Buat sebuah tombol untuk mengimport data ke database
            }
                                echo "</form>";
                        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
                                // Munculkan pesan validasi
                                echo "<div style='color: red;margin-bottom: 10px;'>
                                        Hanya File Excel 2007 (.xlsx) yang diperbolehkan
                                    </div>";
                            }
                            ?>
                        </div>
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