<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keuangan extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->view('template/rupiah');
        $this->load->library('user_agent');
        $this->load->model(array('Keuangan_model'));
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
        $user = $this->user;
        $data = [
            'user'         => $user,
            'users'     => $this->ion_auth->user()->row(),
        ];

        if ($this->ion_auth->is_admin()) {
            $data['info_box'] = $this->admin_box();
            $plotting  = array('1', '2', '3', '4', '5', '6', '7');
            $plotting2 = array('1', '2', '3', '4');
            $data['get_plot'] = $this->Keuangan_model->get_max($plotting)->result();
            $data['get_plot2'] = $this->Keuangan_model->get_max2($plotting2)->result();
        }
        $this->template->load('template/template', 'keuangan/dashboard/dashboard', $data);
        $this->load->view('template/datatables');
    }

    public function admin_box()
    {
        $box = [
            [
                'box'         => 'light-blue',
                'total'     => $this->Keuangan_model->total('karyawan'),
                'title'        => 'Data Siswa',
                'size_class'        => 'col-lg-3 col-xs-6',
                'link'        => 'siswa',
                'icon'        => 'user-graduate'
            ],
            [
                'box'         => 'olive',
                'total'     => $this->Keuangan_model->total('jabatan'),
                'title'        => 'Data Nasabah',
                'size_class'        => 'col-lg-3 col-xs-6',
                'link'        => 'nasabah',
                'icon'        => 'user'
            ],
            [
                'box'         => 'yellow-active',
                'total'     => 'Rp. ' . rupiah($this->Keuangan_model->total('gedung')),
                'title'        => 'Saldo Hari Ini',
                'size_class'        => 'col-lg-6 col-xs-6',
                'link'        => '#',
                'icon'        => 'building'
            ],
            [
                'box'         => 'red',
                'total'     => 'Rp. ' . rupiah($this->Keuangan_model->total('shift')),
                'title'        => 'Saldo Keseluruhan',
                'size_class'        => 'col-lg-6 col-xs-6',
                'link'        => '#',
                'icon'        => 'retweet'
            ],
            [
                'box'         => 'red',
                'total'     => 'Rp. ' . rupiah($this->Keuangan_model->total('shift')),
                'title'        => 'Saldo Bulan Ini',
                'size_class'        => 'col-lg-6 col-xs-6',
                'link'        => '#',
                'icon'        => 'retweet'
            ],
        ];
        $info_box = json_decode(json_encode($box), FALSE);
        return $info_box;
    }


    public function data()
    {

        $this->output_json($this->Keuangan_model->getData(), false);
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
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
        $user = $this->user;
        $data = array(
            'box' => 'info',
            'button' => 'Create',
            'action' => site_url('kelas/create_action'),
            'kode_jenjang' => set_value('kode_jenjang'),
            'nama_karyawan' => set_value('nama_karyawan'),
            'jabatan' => set_value('jabatan'),
            'id_shift' => set_value('id_shift'),
            'gedung_id' => set_value('gedung_id'),
            'id' => set_value('id'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'kelas/kelas_form', $data);
    }
    public function create_action()
    {
        $kelas = $this->input->post('kelas', TRUE);
        $kode_jenjang = $this->input->post('kode_jenjang', TRUE);
        $nama_kelas = $this->input->post('nm_kelas', TRUE);
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            // redirect(site_url('karyawab'));
            $this->create();
        } else {
            $kode_kelas = $kelas . '-' . $kode_jenjang . '-' . $nama_kelas;
            $data = array(
                'kode_kelas' => $kode_kelas,
                'kelas' => $kelas,
                'kode_jenjang' => $kode_jenjang,
                'nama_kelas' => $nama_kelas,
            );
            // var_dump($data);
            $this->Keuangan_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan kelas'));
            redirect(site_url('kelas'));
        }
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
        $row = $this->Keuangan_model->get_by_id($id);
        if ($row) {
            $data = array(
                'box' => 'danger',
                'button' => 'Update',
                'action' => site_url('karyawan/update_action'),
                'id_karyawan' => set_value('id_karyawan', $row->id_karyawan),
                'nama_karyawan' => set_value('nama_karyawan', $row->nama_karyawan),
                'jabatan' => set_value('jabatan', $row->jabatan),
                'id_shift' => set_value('shift', $row->id_shift),
                'gedung_id' => set_value('gedung_id', $row->gedung_id),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
                'id' => set_value('id', $row->id),
            );
            $this->template->load('template/template', 'karyawan/karyawan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('karyawan'));
        }
    }

    public function update_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_karyawan', TRUE));
        } else {
            $kode = $this->Jabatan_model->get_by_id($this->input->post('jabatan'));
            $row = $this->Keuangan_model->get_by_id($this->input->post('id'));
            $id_karyawan = $row->id_karyawan;
            $kodejbt = $kode->nama_jabatan;
            $kodelama = substr($id_karyawan, 0, 1);
            $kodebaru = substr($kodejbt, 0, 1);
            $updatekode = str_replace($kodelama, $kodebaru, $id_karyawan);
            $data = array(
                'id_karyawan' => $updatekode,
                'nama_karyawan' => $this->input->post('nama_karyawan', TRUE),
                'jabatan' => $this->input->post('jabatan', TRUE),
                'id_shift' => $this->input->post('id_shift', TRUE),
                'gedung_id' => $this->input->post('gedung_id', TRUE),
            );

            $this->Keuangan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data karyawan'));
            redirect(site_url('karyawan'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Keuangan_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Keuangan_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data kelas'));
            redirect(site_url('kelas'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('kelas'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('kode_jenjang', 'kode jenjang', 'trim|required');
        $this->form_validation->set_rules('nm_kelas', 'nama kelas', 'trim|required');
        $this->form_validation->set_rules('kelas', 'kelas', 'trim|required');
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
}