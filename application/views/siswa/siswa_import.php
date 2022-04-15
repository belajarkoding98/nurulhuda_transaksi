<body class="hold-transition skin-blue layout-top-nav" onLoad="pindah()">

    <div class="container">
        <section class="content">
            <div class="row">
                <div class="col-md-10">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">UPLOAD FILE</h3>
                        </div>
                        <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
                        <form method="post" action="<?= base_url('siswa/form'); ?>" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">IMPORT FILE EXCEL DI SINI</label>
                                    <input class="form-control" type="file" name="file" required>
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary btn-lg btn3d" name="preview"
                                    value="Preview">
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
                                echo "<form method='post' action='" . site_url("siswa/import") . "'>";

                                // Buat sebuah div untuk alert validasi kosong
                                echo "<div style='color: red;' id='kosong'>
                                </div>";

                                echo "<table border='1' cellpadding='8'>
		<tr>
			<th colspan='9'>Preview Data</th>
		</tr>
		<tr>
			<th>Nama Siswa</th>
			<th>NPS</th>
			<th>NIM</th>
			<th>NISN</th>
			<th>NIK</th>
			<th>No Absen</th>
			<th>Status</th>
			<th>Jenis Kelamin</th>
			<th>Status</th>
		</tr>";

                                $numrow = 1;
                                $kosong = 0;

                                // Lakukan perulangan dari data yang ada di excel
                                // $sheet adalah variabel yang dikirim dari controller
                                foreach ($sheet as $row) {
                                    // Ambil data pada excel sesuai Kolom
                                    $nama = $row['A']; // Ambil data nama
                                    $nps = $row['B']; // Ambil data nama
                                    $nim = $row['C']; // Ambil data NIS
                                    $nisn = $row['D']; // Ambil data NIS
                                    $nik = $row['E']; // Ambil data NIS
                                    $no_absen = $row['F']; // Ambil data NIS
                                    $kelas = $row['G']; // Ambil data NIS
                                    $jenis_kelamin = $row['H']; // Ambil data jenis kelamin
                                    $status = $row['I']; // Ambil data alamat

                                    // Cek jika semua data tidak diisi
                                    if ($nisn == "" && $nama == "" && $jenis_kelamin == "" && $nik == "")
                                        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                                    // Cek $numrow apakah lebih dari 1
                                    // Artinya karena baris pertama adalah nama-nama kolom
                                    // Jadi dilewat saja, tidak usah diimport
                                    if ($numrow > 1) {
                                        // Validasi apakah semua data telah diisi
                                        $nps_td = (!empty($nps)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                        $nisn_td = (!empty($nisn)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                        $nim_td = (!empty($nim)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $nik_td = (!empty($nik)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $no_absen_td = (!empty($no_absen)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $nama_td = (!empty($nama)) ? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                                        $kelas_td = (!empty($kelas)) ? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                                        $jk_td = (!empty($jenis_kelamin)) ? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                                        $status_td = (!empty($status)) ? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah

                                        // Jika salah satu data ada yang kosong
                                        if ($nisn == "" or $nama == "" or $jenis_kelamin == "" or $nik == "") {
                                            $kosong++; // Tambah 1 variabel $kosong
                                        }

                                        echo "<tr>";
                                        echo "<td" . $nama_td . ">" . $nama . "</td>";
                                        echo "<td" . $nps_td . ">" . $nps . "</td>";
                                        echo "<td" . $nim_td . ">" . $nim . "</td>";
                                        echo "<td" . $nisn_td . ">" . $nisn . "</td>";
                                        echo "<td" . $nik_td . ">" . $nik . "</td>";
                                        echo "<td" . $no_absen_td . ">" . $no_absen . "</td>";
                                        echo "<td" . $kelas_td . ">" . $kelas . "</td>";
                                        echo "<td" . $jk_td . ">" . $jenis_kelamin . "</td>";
                                        echo "<td" . $status_td . ">" . $status . "</td>";
                                        echo "</tr>";
                                    }

                                    $numrow++; // Tambah 1 setiap kali looping
                                }

                                echo "</table>";

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

                                    // Buat sebuah tombol untuk mengimport data ke database
                                    echo "<button class='btn btn-success' type='submit' name='import'>Import</button>";
                                    echo "<a class='btn btn-danger' href='" . site_url("siswa") . "'>Cancel</a>";
                                }

                                echo "</form>";
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