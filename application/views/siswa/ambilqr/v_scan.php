<style>
.bg-card {
    /* background-image: 'assets/images/kartu_santri.png'; */
    background: url('http://localhost/absensiqrcode/assets/images/kartu_santri.png');
    background-repeat: no-repeat;
    background-size: contain;
}

.img-responsive {
    padding-top: 100px;
    padding-left: 50px;
}
</style>
<div class="box box-widget">
    <?php
    // $params['data'] = $nps;
    // $params['level'] = 'H';
    // $params['size'] = 4;
    // $params['savename'] = FCPATH . "uploads/barcode_image/" . $nps . '_' . $nama_siswa . '.png';
    // $this->Siswa->set_barcode($params);
    ?>

    <div id="print-area">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user-2 bg-card">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
                <div class="widget-user-image">
                    <img class="img-responsive"
                        src="<?php echo base_url('uploads/barcode_image/') . $nps . '_' . $nama_siswa . '.png'; ?>" />
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username"><?php echo $nps ?></h3>
                <h5 class="widget-user-desc"><?php echo $nama_siswa; ?></h5>
                <button onclick="printDiv('print-area')" class='pull-right'><i class='fa fa-print'></i> Print</button>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    <li><a href="#">Jenis Kelamin : <?php echo $jk; ?> </a></li>
                    <li><a href="#">Tempat, Tgl Lahir : <?php echo $tempat_lahir . ', ' . $tgl_lahir; ?> </a></li>
                    <li><a href="#">Kelas : <?php echo $kelas; ?> </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>