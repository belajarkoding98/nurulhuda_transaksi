<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    private $filename; // Kita tentukan nama filenya

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent', 'zend');
        $this->load->model(array('Siswa_model', 'Jabatan_model'));
        $this->load->library('form_validation', 'ion_auth');
        $this->load->helper('url');
        $this->user = $this->ion_auth->user()->row();
    }

    public function messageAlert($type, $title)
    {
        $messageAlert = "
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000
      });
      Toast.fire({
          type: '" . $type . "',
          title: '" . $title . "'
      });
      ";
        return $messageAlert;
    }

    public function index()
    {
        $chek = $this->ion_auth->is_admin();

        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $siswa = $this->Siswa_model->get_all_query();
        $data = array(
            'siswa_data' => $siswa,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'siswa/siswa_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->Siswa_model->getDataSiswa(), false);
    }

    public function rd($id)
    {
        $user = $this->user;
        $row = $this->Siswa_model->get_by_id_query($this->uri->segment(3));

        if ($row) {
            $uri = $this->uri->segment(3);
            $data = array(
                'nps' => $row->nps,
                'nim' => $row->nim,
                'nisn' => $row->nisn,
                'nik' => $row->nik,
                'nama_siswa' => $row->nama_siswa,
                'jk' => $row->jk,
                'tempat' => $row->tempat_lahir,
                'tgl_lahir' => $row->tgl_lahir,
                'jk' => $row->jk,
                'no_hp' => $row->no_hp,
                'alamat' => $row->alamat,
                'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'siswa/siswa_read', $data, $uri);
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Data tidak ditemukan!'));
            redirect(site_url('siswa'));
        }
    }

    public function create()
    {
        $chek = $this->ion_auth->is_admin();
        if (!$chek) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $cek_urutan = $this->Siswa_model->getOneData();
        if ($cek_urutan != null) {
            $urutan = substr($cek_urutan['nps'], -4);
            $urutan++;
            $no = str_pad($urutan, 4, "0", STR_PAD_LEFT);
            $nps = '522' . date("Y") . $no;
            $nim = '13123208002619' . $no;
        } else {
            $nps = '522' . date("Y") . '0001';
            $nim = '13123208002619' . '0001';
        }

        $user = $this->user;
        $data = array(
            'box' => 'info',
            'button' => 'Create',
            'nps' => $nps,
            'nim' => $nim,
            'action' => site_url('siswa/create_action'),
            'action1' => site_url('siswa/create_orang_tua'),
            'action2' => site_url('siswa/create_tempat_tinggal'),
            'action3' => site_url('siswa/create_sekolah_sebelumnya'),
            'action4' => site_url('siswa/create_bantuan'),
            'action5' => site_url('siswa/create_kesehatan'),
            'id' => set_value('id'),
            'nisn' => set_value('nisn'),
            'nik' => set_value('nik'),
            'nama_siswa' => set_value('nama_siswa'),
            'tempat_lahir' => set_value('tempat_lahir'),
            'tgl_lahir' => set_value('tgl_lahir'),
            'kode_ta' => set_value('kode_ta'),
            'kode_jenjang' => set_value('kode_jenjang'),
            'kode_kelas' => set_value('kode_kelas'),
            'id' => set_value('id'),

            'no_kk' => set_value('no_kk'),
            'nama_kk' => set_value('nama_kk'),
            'nama_ayah' => set_value('nama_ayah'),
            'tempat_lahir_ayah' => set_value('tempat_lahir_ayah'),
            'tgl_lahir_ayah' => set_value('tgl_lahir_ayah'),
            'nik_ayah' => set_value('nik_ayah'),
            'status_ayah' => set_value('status_ayah'),
            'pendidikan_ayah' => set_value('pendidikan_ayah'),
            'pekerjaan_ayah' => set_value('pekerjaan_ayah'),
            'penghasilan_ayah' => set_value('penghasilan_ayah'),
            'no_hp_ayah' => set_value('no_hp_ayah'),

            'nama_ibu' => set_value('nama_ibu'),
            'tempat_lahir_ibu' => set_value('tempat_lahir_ibu'),
            'tgl_lahir_ibu' => set_value('tgl_lahir_ibu'),
            'nik_ibu' => set_value('nik_ibu'),
            'status_ibu' => set_value('status_ibu'),
            'pendidikan_ibu' => set_value('pendidikan_ibu'),
            'pekerjaan_ibu' => set_value('pekerjaan_ibu'),
            'penghasilan_ibu' => set_value('penghasilan_ibu'),
            'no_hp_ibu' => set_value('no_hp_ibu'),

            'jenis_tempat_tinggal' => set_value('jenis_tempat_tinggal'),
            'alamat' => set_value('alamat'),
            'kode_provinsi' => set_value('kode_provinsi'),
            'provinsi' => set_value('provinsi'),
            'kode_kabupaten' => set_value('kode_kabupaten'),
            'kabupaten' => set_value('kabupaten'),
            'kode_kecamatan' => set_value('kode_kecamatan'),
            'kecamatan' => set_value('kecamatan'),
            'kode_kelurahan' => set_value('kode_kelurahan'),
            'kelurahan' => set_value('kelurahan'),
            'kode_pos' => set_value('kode_pos'),
            'jarak_ke_sekolah' => set_value('jarak_ke_sekolah'),
            'transportasi' => set_value('transportasi'),
            'koor_lintang_sekolah' => set_value('koor_lintang_sekolah'),
            'koor_bujur_sekolah' => set_value('koor_bujur_sekolah'),

            'jenjang_sekolah_sblm' => set_value('jenjang_sekolah_sblm'),
            'status_sekolah_sblm' => set_value('status_sekolah_sblm'),
            'npsn' => set_value('npsn'),
            'nama_sekolah' => set_value('nama_sekolah'),
            'lokasi_sekolah' => set_value('lokasi_sekolah'),
            'no_peserta_un' => set_value('no_peserta_un'),
            'no_skhun' => set_value('no_skhun'),
            'no_ijasah' => set_value('no_ijasah'),
            'total_nilai' => set_value('total_nilai'),
            'tahun_ajaran' => set_value('tahun_ajaran'),

            'tinggi' => set_value('tinggi'),
            'bb' => set_value('bb'),
            'ling_kepala' => set_value('ling_kepala'),
            'hepa_b' => set_value('hepa_b'),
            'polio' => set_value('polio'),
            'campak' => set_value('campak'),

            'no_kip' => set_value('no_kip'),
            'no_pkh' => set_value('no_pkh'),

            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'siswa/siswa_form', $data);
    }
    public function create_action()
    {
        $cek_urutan = $this->Siswa_model->getOneData();
        $id = $cek_urutan['id'];
        $id++;
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'id' => $id,
                'nps' => $this->input->post('nps'),
                'nim' => $this->input->post('nim'),
                'nisn' => $this->input->post('nisn'),
                'nik' => $this->input->post('nik'),
                'no_absen' => $id,
                'nama_siswa' => ucwords($this->input->post('nama_siswa', TRUE)),
                'jk' => $this->input->post('jk_siswa', TRUE),
                'status' => $this->input->post('status', TRUE),
                'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
                'tgl_lahir' => $this->input->post('tgl_lahir', TRUE),
                'agama' => $this->input->post('agama', TRUE),
                'warga_negara' => $this->input->post('negara', TRUE),
                'hobi' => $this->input->post('hobi', TRUE),
                'cita_cita' => $this->input->post('cita', TRUE),
                'tk' => $this->input->post('tk', TRUE),
                'paud' => $this->input->post('paud', TRUE),
                'anak_ke' => $this->input->post('anak_ke', TRUE),
                'jml_saudara' => $this->input->post('jml_saudara', TRUE),
                'tgl_masuk' => $this->input->post('tgl_masuk', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE),
                'kode_ta' => $this->input->post('kode_ta', TRUE),
                'kode_jenjang' => $this->input->post('kode_jenjang', TRUE),
                'kelas' => $this->input->post('kode_kelas', TRUE),
            );
            $this->Siswa_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan siswa'));
            redirect(site_url('siswa'));
        }
    }

    public function create_kesehatan()
    {
        $cek_urutan = $this->Siswa_model->getOneData();
        if ($cek_urutan != null) {
            $urutan = substr($cek_urutan['nps'], -4);
            $urutan++;
            $no = str_pad($urutan, 4, "0", STR_PAD_LEFT);
            $nps = '522' . date("Y") . $no;
        } else {
            $nps = '522' . date("Y") . '0001';
        }

        $data = array(
            'nps' => $nps,
            'tinggi' => $this->input->post('tinggi'),
            'bb' => $this->input->post('bb'),
            'ling_kepala' => $this->input->post('ling_kepala'),
            'hepatitis_b' => $this->input->post('hepa_b'),
            'polio' => $this->input->post('polio'),
            'campak' => $this->input->post('campak'),
        );
        $this->Siswa_model->insert_data("kesehatan_siswa", $data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan kesehatan'));
        redirect(site_url('siswa'));
    }

    public function create_orang_tua()
    {
        $cek_urutan = $this->Siswa_model->getOneData();
        if ($cek_urutan != null) {
            $urutan = substr($cek_urutan['nps'], -4);
            $urutan++;
            $no = str_pad($urutan, 4, "0", STR_PAD_LEFT);
            $nps = '522' . date("Y") . $no;
        } else {
            $nps = '522' . date("Y") . '0001';
        }

        $data = array(
            'no_kk' => $this->input->post('no_kk'),
            'nama_kepala_keluarga' => $this->input->post('nama_kk'),
            'nama_ayah' => $this->input->post('nama_ayah'),
            'tempat_lahir_ayah' => $this->input->post('tempat_lahir_ayah'),
            'tgl_lahir_ayah' => $this->input->post('tgl_lahir_ayah'),
            'nik_ayah' => $this->input->post('nik_ayah'),
            'status_ayah' => $this->input->post('status_ayah'),
            'pendidikan_ayah' => $this->input->post('pendidikan_ayah'),
            'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
            'penghasilan_ayah' => $this->input->post('penghasilan_ayah'),
            'no_hp_ayah' => $this->input->post('no_hp_ayah'),

            'nama_ibu' => $this->input->post('nama_ibu'),
            'tempat_lahir_ibu' => $this->input->post('tempat_lahir_ibu'),
            'tgl_lahir_ibu' => $this->input->post('tgl_lahir_ibu'),
            'nik_ibu' => $this->input->post('nik_ibu'),
            'status_ibu' => $this->input->post('status_ibu'),
            'pendidikan_ibu' => $this->input->post('pendidikan_ibu'),
            'pekerjaan_ibu' => $this->input->post('pekerjaan_ibu'),
            'penghasilan_ibu' => $this->input->post('penghasilan_ibu'),
            'no_hp_ibu' => $this->input->post('no_hp_ibu'),

            'provinsi' => $this->input->post('provinsi'),
            'kabupaten' => $this->input->post('kabupaten'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'kode_pos' => $this->input->post('kode_pos'),
            'koor_lintang_rumah' => $this->input->post('koor_lintang_rumah'),
            'koor_bujur_rumah' => $this->input->post('koor_bujur_rumah'),
        );
        $this->Siswa_model->insert_data("orang_tua_siswa", $data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan kesehatan'));
        redirect(site_url('siswa'));
    }

    public function create_bantuan()
    {
        $cek_urutan = $this->Siswa_model->getOneData();
        if ($cek_urutan != null) {
            $urutan = substr($cek_urutan['nps'], -4);
            $urutan++;
            $no = str_pad($urutan, 4, "0", STR_PAD_LEFT);
            $nps = '522' . date("Y") . $no;
        } else {
            $nps = '522' . date("Y") . '0001';
        }

        $data = array(
            'nps' => $nps,
            'no_kip' => $this->input->post('no_kip'),
            'no_pkh' => $this->input->post('no_pkh'),
        );
        $this->Siswa_model->insert_data("bantuan_siswa", $data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan bantuan'));
        redirect(site_url('siswa'));
    }

    public function create_sekolah_sebelumnya()
    {
        $cek_urutan = $this->Siswa_model->getOneData();
        if ($cek_urutan != null) {
            $urutan = substr($cek_urutan['nps'], -4);
            $urutan++;
            $no = str_pad($urutan, 4, "0", STR_PAD_LEFT);
            $nps = '522' . date("Y") . $no;
        } else {
            $nps = '522' . date("Y") . '0001';
        }

        $data = array(
            'nps' => $nps,
            'jenjang_sekolah_sblm' => $this->input->post('jenjang_sekolah_sblm'),
            'status_sekolah_sblm' => $this->input->post('status_sekolah_sblm'),
            'npsn' => $this->input->post('npsn'),
            'nama_sekolah' => $this->input->post('nama_sekolah'),
            'lokasi_sekolah' => $this->input->post('lokasi_sekolah'),
            'no_peserta_un' => $this->input->post('no_peserta_un'),
            'no_skhun' => $this->input->post('no_skhun'),
            'no_ijasah' => $this->input->post('no_ijasah'),
            'total_nilai' => $this->input->post('total_nilai'),
            'tahun_ajaran' => $this->input->post('tahun_ajaran'),
        );
        $this->Siswa_model->insert_data("sekolah_sebelumnya", $data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan bantuan'));
        redirect(site_url('siswa'));
    }

    public function create_tempat_tinggal()
    {
        $cek_urutan = $this->Siswa_model->getOneData();
        if ($cek_urutan != null) {
            $urutan = substr($cek_urutan['nps'], -4);
            $urutan++;
            $no = str_pad($urutan, 4, "0", STR_PAD_LEFT);
            $nps = '522' . date("Y") . $no;
            // $id = $cek_urutan['id'];
        } else {
            $nps = '522' . date("Y") . '0001';
            // $id = '1';
        }

        $data = array(
            // 'id' => $id,
            'nps' => $nps,
            'jenis_tempat_tinggal' => $this->input->post('jenis_tempat_tinggal'),
            'alamat' => $this->input->post('alamat'),
            'provinsi' => $this->input->post('provinsi'),
            'kabupaten' => $this->input->post('kabupaten'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'kode_pos' => $this->input->post('kode_pos'),
            'jarak_ke_sekolah' => $this->input->post('jarak_ke_sekolah'),
            'transportasi' => $this->input->post('transportasi'),
            'koor_lintang_sekolah' => $this->input->post('koor_lintang_sekolah'),
            'koor_bujur_sekolah' => $this->input->post('koor_bujur_sekolah'),
        );
        $this->Siswa_model->insert_data("tempat_tinggal_siswa", $data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan Tempat Tinggal Siswa'));
        redirect(site_url('siswa'));
    }

    function formatNbr($nbr)
    {
        if ($nbr == 0)
            return "001";
        else if ($nbr < 10)
            return "00" . $nbr;
        elseif ($nbr >= 10 && $nbr < 100)
            return "0" . $nbr;
        else
            return strval($nbr);
    }


    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $user = $this->user;
        $row = $this->Siswa_model->get_by_id($id);
        if ($row) {
            $data = array(
                'box' => 'danger',
                'button' => 'Update',
                'action' => site_url('siswa/update_action'),
                'id_siswa' => set_value('id_siswa', $row->id_siswa),
                'nama_siswa' => set_value('nama_siswa', $row->nama_siswa),
                'jabatan' => set_value('jabatan', $row->jabatan),
                'id_shift' => set_value('shift', $row->id_shift),
                'gedung_id' => set_value('gedung_id', $row->gedung_id),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
                'id' => set_value('id', $row->id),
            );
            $this->template->load('template/template', 'siswa/siswa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('siswa'));
        }
    }

    public function update_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_siswa', TRUE));
        } else {
            $kode = $this->Jabatan_model->get_by_id($this->input->post('jabatan'));
            $row = $this->Siswa_model->get_by_id($this->input->post('id'));
            $id_siswa = $row->id_siswa;
            $kodejbt = $kode->nama_jabatan;
            $kodelama = substr($id_siswa, 0, 1);
            $kodebaru = substr($kodejbt, 0, 1);
            $updatekode = str_replace($kodelama, $kodebaru, $id_siswa);
            $data = array(
                'id_siswa' => $updatekode,
                'nama_siswa' => $this->input->post('nama_siswa', TRUE),
                'jabatan' => $this->input->post('jabatan', TRUE),
                'id_shift' => $this->input->post('id_shift', TRUE),
                'gedung_id' => $this->input->post('gedung_id', TRUE),
            );

            $this->Siswa_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data siswa'));
            redirect(site_url('siswa'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Siswa_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Siswa_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data siswa'));
            redirect(site_url('siswa'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('siswa'));
            // redirect(site_url('siswa'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('nisn', 'nisn', 'trim|required');
        $this->form_validation->set_rules('nik', 'nik', 'trim|required');
        $this->form_validation->set_rules('nama_siswa', 'nama siswa', 'trim|required');
        $this->form_validation->set_rules('jk_siswa', 'jk_siswa', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'trim|required');
        $this->form_validation->set_rules('tgl_lahir', 'tanggal lahir', 'trim|required');
        $this->form_validation->set_rules('agama', 'agama', 'trim|required');
        $this->form_validation->set_rules('negara', 'warga negara', 'trim|required');
        $this->form_validation->set_rules('hobi', 'hobi', 'trim|required');
        $this->form_validation->set_rules('cita', 'cita-cita', 'trim|required');
        $this->form_validation->set_rules('tk', 'pernah tk', 'trim|required');
        $this->form_validation->set_rules('paud', 'pernah paud', 'trim|required');
        $this->form_validation->set_rules('anak_ke', 'anak ke', 'trim|required');
        $this->form_validation->set_rules('jml_saudara', 'jumlah saudara', 'trim|required');
        $this->form_validation->set_rules('tgl_masuk', 'tanggal masuk', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required');
        $this->form_validation->set_rules('tahunajaran', 'Tahun Ajaran', 'trim|required');
        $this->form_validation->set_rules('kode_jenjang', 'Kode Jenjang', 'trim|required');
        $this->form_validation->set_rules('kode_kelas', 'Kode Kelas', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function _set_useragent()
    {
        if ($this->agent->is_mobile('iphone')) {
            $this->agent = 'iphone';
        } elseif ($this->agent->is_mobile()) {
            $this->agent = 'mobile';
        } else {
            $this->agent = 'desktop';
        }
    }

    public function showw($id)
    {
        $this->load->library('zend');
        $this->load->model('GenBar_model');
        $car = $this->Siswa_model->getShow_query($id);
        if ($car->num_rows() > 0) {
            foreach ($car->result() as $row) {
                $shows = array(
                    'nps' => $row->nps,
                    'nama_siswa' => $row->nama_siswa,
                    'jk' => $row->jk,
                    'tempat_lahir' => $row->tempat_lahir,
                    'tgl_lahir' => $row->tgl_lahir,
                    'kelas' => $row->kelas,
                    'barcode' => $this->set_barcode($row->nps, $row->nama_siswa)
                );
                // $this->set_barcode($row->nps);
                $this->load->view('siswa/ambilqr/v_scan', $shows);
            }
        } else {
            $this->load->view('siswa/ambilqr/v_scan_kosong');
        }
    }

    public function import_siswa()
    {
        $chek = $this->ion_auth->is_admin();

        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        // $siswa = $this->Siswa_model->get_all_query();
        $data = array(
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'siswa/siswa_import', $data);
    }

    public function form()
    {
        $this->filename = "import_data_siswa_" . date('Ym');
        $data = array(); // Buat variabel $data sebagai array

        $chek = $this->ion_auth->is_admin();

        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        // $siswa = $this->Siswa_model->get_all_query();
        $data = array(
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
            $upload = $this->Siswa_model->upload_file($this->filename);

            if ($upload['result'] == "success") { // Jika proses upload sukses
                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

                $excelreader = new PHPExcel_Reader_Excel2007();
                $loadexcel = $excelreader->load('excel/' . $this->filename . '.xlsx'); // Load file yang tadi diupload ke folder excel
                $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
                // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
                $data['sheet'] = $sheet;
            } else { // Jika proses upload gagal
                $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
                $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Data Gagal di Preview'));
            }
        }

        // redirect(site_url('siswa/tambah_siswa'));
        // $this->load->view('siswa/siswa_import', $data);

        $this->template->load('template/template', 'siswa/siswa_import', $data);
    }

    public function import()
    {
        $this->filename = "import_data_siswa_" . date('Ym');

        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/' . $this->filename . '.xlsx'); // Load file yang telah diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

        // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
        $data = array();

        $cek_urutan = $this->Siswa_model->getOneData();
        $id = $cek_urutan['id'];

        if (empty($id)) {
            $no = 0;
        } else {
            $no = $id;
        }
        $numrow = 1;
        foreach ($sheet as $row) {
            // Cek $numrow apakah lebih dari 1
            // Artinya karena baris pertama adalah nama-nama kolom
            // Jadi dilewat saja, tidak usah diimport
            if ($numrow > 1) {
                // Kita push (add) array data ke variabel data
                array_push($data, array(
                    'id' => $no,
                    'nama_siswa' => $row['A'], // Insert data nama dari kolom B di excel
                    'nps' => $row['B'], // Insert data nis dari kolom A di excel
                    'nim' => $row['C'], // Insert data nis dari kolom A di excel
                    'nisn' => $row['D'], // Insert data nis dari kolom A di excel
                    'nik' => $row['E'], // Insert data nis dari kolom A di excel
                    'no_absen' => $row['F'], // Insert data nis dari kolom A di excel
                    'kelas' => $row['G'], // Insert data nis dari kolom A di excel
                    'jk' => $row['H'], // Insert data jenis kelamin dari kolom C di excel
                    'status' => $row['I'], // Insert data alamat dari kolom D di excel
                    'tempat_lahir' => $row['J'], // Insert data alamat dari kolom D di excel
                    'tgl_lahir' => $row['K'], // Insert data alamat dari kolom D di excel
                    'agama' => $row['L'], // Insert data alamat dari kolom D di excel
                    'warga_negara' => $row['M'], // Insert data alamat dari kolom D di excel
                    'hobi' => $row['N'], // Insert data alamat dari kolom D di excel
                    'cita_cita' => $row['O'], // Insert data alamat dari kolom D di excel
                    'tk' => $row['P'], // Insert data alamat dari kolom D di excel
                    'paud' => $row['Q'], // Insert data alamat dari kolom D di excel
                    'anak_ke' => $row['R'], // Insert data alamat dari kolom D di excel
                    'jml_saudara' => $row['S'], // Insert data alamat dari kolom D di excel
                    'tgl_masuk' => $row['T'], // Insert data alamat dari kolom D di excel
                    'alamat' => $row['U'], // Insert data alamat dari kolom D di excel
                    'no_hp' => $row['V'], // Insert data alamat dari kolom D di excel
                    'kode_ta' => $row['W'], // Insert data alamat dari kolom D di excel
                    'kode_jenjang' => $row['X'], // Insert data alamat dari kolom D di excel
                ));
                array_push($data_ortu, array(
                    'id' => $no,
                    'no_kk' => $row['A'], // Insert data nama dari kolom B di excel
                    'nama_kepala_keluarga' => $row['B'], // Insert data nis dari kolom A di excel
                    'nama_ayah' => $row['C'], // Insert data nis dari kolom A di excel
                    'tempat_lahir_ayah' => $row['D'], // Insert data nis dari kolom A di excel
                    'tgl_lahir_ayah' => $row['E'], // Insert data nis dari kolom A di excel
                    'nik_ayah' => $row['F'], // Insert data nis dari kolom A di excel
                    'status_ayah' => $row['G'], // Insert data nis dari kolom A di excel
                    'pendidikan_ayah' => $row['H'], // Insert data jenis kelamin dari kolom C di excel
                    'pekerjaan_ayah' => $row['I'], // Insert data alamat dari kolom D di excel
                    'penghasilan_ayah' => $row['J'], // Insert data alamat dari kolom D di excel
                    'no_hp_ayah' => $row['K'], // Insert data alamat dari kolom D di excel
                    'nama_ibu' => $row['L'], // Insert data alamat dari kolom D di excel
                    'tempat_lahir_ibu' => $row['M'], // Insert data alamat dari kolom D di excel
                    'tgl_lahir_ibu' => $row['N'], // Insert data alamat dari kolom D di excel
                    'nik_ibu' => $row['O'], // Insert data alamat dari kolom D di excel
                    'status_ibu' => $row['P'], // Insert data alamat dari kolom D di excel
                    'pendidikan_ibu' => $row['Q'], // Insert data alamat dari kolom D di excel
                    'pekerjaan_ibu' => $row['R'], // Insert data alamat dari kolom D di excel
                    'penghasilan_ibu' => $row['S'], // Insert data alamat dari kolom D di excel
                    'no_hp_ibu' => $row['T'], // Insert data alamat dari kolom D di excel
                    'alamat' => $row['U'], // Insert data alamat dari kolom D di excel
                    'kode_provinsi' => $row['V'], // Insert data alamat dari kolom D di excel
                    'provinsi' => $row['W'], // Insert data alamat dari kolom D di excel
                    'kode_kabupaten' => $row['X'], // Insert data alamat dari kolom D di excel
                    'kabupaten' => $row['X'], // Insert data alamat dari kolom D di excel
                    'kode_kecamatan' => $row['X'], // Insert data alamat dari kolom D di excel
                    'kecamatan' => $row['X'], // Insert data alamat dari kolom D di excel
                    'kode_kelurahan' => $row['X'], // Insert data alamat dari kolom D di excel
                    'kelurahan' => $row['X'], // Insert data alamat dari kolom D di excel
                    'kode_pos' => $row['X'], // Insert data alamat dari kolom D di excel
                    'koor_lintang_rumah' => $row['X'], // Insert data alamat dari kolom D di excel
                    'koor_bujur_rumah' => $row['X'], // Insert data alamat dari kolom D di excel
                ));
            }
            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
            if ($cek_urutan['nps'] == $row['B']) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Data Ada yang sama!'));
                redirect("siswa/import_siswa"); // Redirect ke halaman awal (ke controller siswa fungsi index)
            }
        }

        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        $this->Siswa_model->insert_multiple('siswa', $data);
        // var_dump($data);
        redirect("Siswa"); // Redirect ke halaman awal (ke controller siswa fungsi index)
    }

    // public function barcode()
    // {
    //     // You can put anything here to generate of barcode
    //     $string = 'code39';
    //     $this->set_barcode($string);
    // }

    private function set_barcode($code, $nama_siswa)
    {
        // Load library
        $this->load->library('zend');
        // Load in folder Zend
        $this->zend->load('Zend/Barcode');
        // Generate barcode
        $file = Zend_Barcode::draw('code128', 'image', array('text' => $code, 'drawText' => false), array());

        $store_image = imagepng($file, "uploads/barcode_image/" . $code . '_' . $nama_siswa . '.png');
        return $store_image;
    }
}
