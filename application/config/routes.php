<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'Auth/index';
$route['logout'] = 'Auth/logout';

// karyawan
$route['tambah_anggota'] = 'karyawan/create';
$route['tambah_jabatan'] = 'jabatan/create';
$route['tambah_shift'] = 'shift/create';
$route['tambah_shift'] = 'shift/create';
$route['tambah_gajiagt'] = 'Gaji_agt/create';
$route['tambah_lokasi'] = 'lokasi/create';
$route['tambah_menu'] = 'menu/create';
$route['tambah_grup'] = 'groups/create';
$route['tambah_user'] = 'auth/create_user';
$route['karyawan/lihat/(:num)'] = 'karyawan/rd/$1';
$route['jabatan/lihat/(:num)'] = 'jabatan/rd/$1';
$route['shift/lihat/(:num)'] = 'shift/rd/$1';
$route['lokasi/lihat/(:num)'] = 'lokasi/rd/$1';
$route['presensi/lihat/(:num)'] = 'presensi/rd/$1';
$route['audit/data'] = 'user_audit_trails/data';

//siswa
$route['siswa/lihat/(:num)'] = 'siswa/rd/$1';
$route['tambah_siswa'] = 'siswa/create';
$route['siswa/cetak/(:num)'] = 'siswa/showw/$1';

//jenjang
$route['tambah_jenjang'] = 'jenjang/create';

//kelas
$route['tambah_kelas'] = 'kelas/create';

//Tahun ajaaran
$route['tambah_tahunajaran'] = 'tahunajaran/create';

//Tahun nasabah
$route['tambah_nasabah'] = 'nasabah/create';
$route['topup_nasabah'] = 'nasabah/topup';

//Nasabah


//Upload Data Excel
$route['import_siswa'] = 'siswa/import_siswa';
$route['import_nasabah'] = 'nasabah/import_nasabah';
$route['import_saldo'] = 'nasabah/import_saldo';
$route['transaksi_nasabah/(:num)'] = 'nasabah/transaksi_nasabah/$1';
$route['setoran_nasabah/(:num)'] = 'nasabah/setoran_nasabah/$1';
$route['penarikan_nasabah/(:num)'] = 'nasabah/penarikan_nasabah/$1';

//create kredit & debit
$route['create_kredit'] = 'nasabah/create_kredit';
$route['create_debit'] = 'nasabah/create_debit';

//update kredit & debit
$route['update_kredit'] = 'nasabah/update_kredit';
$route['update_debit'] = 'nasabah/update_debit';

//menu
$route['laporan_jajan'] = 'transaksi';
$route['laporan_laundry'] = 'laporan/laundry';
$route['laporan_berobat'] = 'laporan/berobat';
$route['laporan_kas_galon'] = 'laporan/kas_galon';
$route['laporan_cukur'] = 'laporan/cukur';
$route['laporan_transaksi'] = 'laporan/transaksi';

//kehilangan kartu
$route['kehilangan_kartu'] = 'kartu';
