<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Kehilangan Kartu | Sistem Nurul Huda</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/card/css/base.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/card/css/vendor.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/card/css/main.css">

    <!-- script
    ================================================== -->
    <script src="<?php echo base_url() ?>assets/card/js/modernizr.js"></script>
    <script src="<?php echo base_url() ?>assets/card/js/pace.min.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <style>
        input[type="text"], textarea, select{
            background-color: #ffffff;
        }
        label, h3{
            color: #fff;
        }
    </style>

</head>

<body id="top">

    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader" class="dots-jump">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>



    <!-- home
    ================================================== -->
    <section id="home" class="s-home target-section" data-parallax="scroll" data-image-src="<?php echo base_url() ?>assets/card/images/bg-nh.JPG" data-natural-width=3000 data-natural-height=2000 data-position-y=center>

        <div class="shadow-overlay"></div>

        <div class="home-content">

            <div class="row home-content__main">

                <div class="home-content__left">
                    <h1>
                    Kehilangan kartu <br>
                    Transaksi?
                    </h1>
    
                    <h3 style="color: white;">
                    Kami memudahkan Ibu/Bapak/Wali Santri/Santri untuk melaporkan kehilangan kartu, dengan menginputkan Nama Santri, Kelas, Orang Tua
                    </h3>
    
                    <div class="home-content__btn-wrap">
                        <a href="#footer" class="btn btn--primary home-content__btn smoothscroll CariDataKartu">
                            Cari Data Kartu
                        </a>
                    </div>
                </div> <!-- end home-content__left-->

                <div class="home-content__right">
                    <img src="<?php echo base_url() ?>assets/card/images/hero-app-screens-800.png" srcset="<?php echo base_url() ?>assets/card/images/hero-app-screens-800.png 1x, <?php echo base_url() ?>assets/card/images/hero-app-screens-1600.png 2x">
                </div> <!-- end home-content__right -->

            </div> <!-- end home-content__main -->

            <ul class="home-content__social">
                <li><a href="#0">Facebook</a></li>
                <li><a href="#0">twitter</a></li>
                <li><a href="#0">Instagram</a></li>
            </ul>

        </div> <!-- end home-content -->

        <a href="#about" class="home-scroll smoothscroll">
            <span class="home-scroll__text">Scroll</span>
            <span class="home-scroll__icon"></span>
        </a> 

    </section> <!-- end s-home -->



    <!-- footer
    ================================================== -->
    <footer class="s-footer footer" id="footer">

        <div class="row section-header align-center">
            <div class="col-full">
                <h1 class="display-1">
                    Cari Data Kartu
                </h1>
                <p class="lead" style="color: white;">
                Cari Nama Lengkap Putra/Putri Ibu/Bapak di bawah ini
                </p>
            </div>
        </div> <!-- end section-header -->

        <div class="row footer__top">

            <div class="col-full footer__subscribe end">
                <div class="subscribe-form">
                        <div class="row">

                            <div class="col-six tab-full">
                
                                <h3>Form Kehilangan Kartu</h3>
                
                                <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="sampleInput">Nama Lengkap</label>
                                        <input class="full-width" type="text" name="nama_lengkap" placeholder="Masukan Nama Lengkap" id="sampleInput" required>
                                    </div>
                                    <div>
                                        <label for="sampleRecipientInput">Jenjang Sekolah</label>
                                        <div class="ss-custom-select">
                                        <select class="form-control full-width" name="kode_jenjang" id="kode_jenjang" required>
                                    <option>--Pilih Kelas--</option>
                                    <?php
                                    foreach ($kode_jenjang as $jenjang) { ?>
                                        <option value="<?= $jenjang->kode_jenjang ?>"><?= $jenjang->jenjang  ?></option>
                                    <?php } ?>
                                    ?>
                                </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="sampleRecipientInput">Kelas Sekolah</label>
                                        <div class="ss-custom-select">
                                        <select class="form-control full-width" name="kode_kelas" id="kode_kelas" required>
                                    <option>--Pilih Kelas--</option>
                                </select>
                                <!-- <php echo cmb_dinamis('kode_kelas', 'kode_kelas', 'kelas', 'kode_kelas', 'kode_kelas', '') ?> -->
                                        </div>
                                    </div>
                                    <div>
                                        <label for="sampleInput">Nama Orang Tua</label>
                                        <input class="full-width" type="text" name="orang_tua" placeholder="Masukan Nama Orang Tua" id="sampleInput"  required>
                                    </div>
                                    <div>
                                        <label for="sampleInput">Keterangan</label>
                                        <textarea name="keterangan" class="full-width" placeholder="Keterangan" id="" cols="30" rows="3"></textarea>
                                    </div>
                                    <input type="file" class="full-width" name="foto" id="fileToUpload" required>
                                    <label class="add-bottom">
                                        <input type="checkbox">
                                        <span class="label-text">Data yang saya inputkan benar</span>
                                    </label>
                                
                                    <input class="btn--primary full-width" type="submit" value="Kirim">
                                </form>
                
                            </div>
                
                            <div class="col-six tab-full">
                
                                <h3>Alert Boxes</h3>
                
                                <br>
                                
                            </div>
                
                        </div> <!-- end row -->
                  
                </div>
            </div>

        </div> <!-- end footer__top -->

        <div class="row footer__bottom">

            <div class="footer__about col-five tab-full left">

                <h4>Tentang Kartu Transaksi.</h4>

                <p>
                Kartu Santri Transaksi merupakan alat pembayaran yang sah dan digunanakan diruang lingkup
                Yayasan Nurul Huda Kertawangunan.
                </p>

                <ul class="footer__social">
                    <li><a href="#0"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                    <li><a href="#0"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#0"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                </ul>
            </div>

            <div class="col-five md-seven tab-full right end">
                <div class="row">

                    <div class="footer__site-links col-five mob-full">
                        <h4>Site links.</h4>

                        <ul class="footer__site-links">
                            <li><a href="#home" class="smoothscroll">Intro</a></li>
                            <li><a href="#about" class="smoothscroll">About</a></li>
                            <li><a href="#features" class="smoothscroll">Features</a></li>
                            <li><a href="#pricing" class="smoothscroll">Pricing</a></li>
                            <li><a href="#download" class="smoothscroll">Download</a></li>
                            <li><a href="#0">Privacy Policy</a></li>
                        </ul>
                    </div>

                    <div class="footer__contact col-seven mob-full">
                        <h4>Contact Us.</h4>

                        <p>
                        WhatsApp: (+62) 811 244 851 <br>
                        Fax: (+63) 555 0100
                        </p>
                        <p>
                        Need help or have a question? Contact us at: <br>
                        <a href="mailto:#0" class="footer__mail-link">ponpesnurulhudakertawangunan@gmail.com</a>
                        </p>
                    </div>

                </div>
            </div>

            <div class="col-full ss-copyright">
                <span>&copy; Copyright Nurul Huda 2022</span> 
                <span>Design by <a href="#">Muhammad Jahidin</a></span>
            </div>

        </div> <!-- end footer__bottom -->

        <div class="go-top">
            <a class="smoothscroll" title="Back to Top" href="#top"></a>
        </div>

    </footer> <!-- end s-footer -->


    <!-- Java Script
    ================================================== -->
    <script>
        $(document).ready(function() {
        $("a.CariDataKartu").click(function(){
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $($(this).attr("href")).offset().top
            }, 500);
        });
        });
    </script>
    <script src="<?php echo base_url() ?>assets/card/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/card/js/plugins.js"></script>
    <script src="<?php echo base_url() ?>assets/card/js/main.js"></script>

    <script>
    $('#kode_jenjang').on('change', function() {
        var kode_jenjang = $(this).val();
        // alert(kode_jenjang)
        if (kode_jenjang == "SDIT") {
            var kelas = ["I", "II", "III", "IV", "V", "VI"];
        } else if (kode_jenjang == "SMPIT") {
            var kelas = ["VII", "VIII", "IX"];
        } else if (kode_jenjang == "MA") {
            var kelas = ["X", "XI", "XII"];
        }

        for (var i = 0; i < kelas.length; i++) {
            $('<option/>').empty();
            $('<option/>').val(kelas[i]).html(kelas[i]).appendTo('#kode_kelas');
        }
    });
</script>
</body>