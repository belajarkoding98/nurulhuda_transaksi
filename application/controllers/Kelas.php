<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kelas extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Kelas_model', 'Jenjang_model'));
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
        $kelas = $this->Kelas_model->get_all_query();
        $data = array(
            'kelas_data' => $kelas,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'kelas/kelas_list', $data);
        $this->load->view('template/datatables');
    }


    public function data()
    {

        $this->output_json($this->Kelas_model->getData(), false);
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
        $row_jenjang = $this->Jenjang_model->get_all_query();
        $user = $this->user;
        $data = array(
            'box' => 'info',
            'button' => 'Create',
            'action' => site_url('kelas/create_action'),
            'kode_jenjang' => $row_jenjang,
            'nama_karyawan' => set_value('nama_karyawan'),
            'jabatan' => set_value('jabatan'),
            'id_shift' => set_value('id_shift'),
            'gedung_id' => set_value('gedung_id'),
            'id' => set_value('id'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        // var_dump($row);
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
            $kode_kelas = $kelas . '-' . $nama_kelas;
            $data = array(
                'kode_kelas' => $kode_kelas,
                'kelas' => $kelas,
                'kode_jenjang' => $kode_jenjang,
                'nama_kelas' => $nama_kelas,
            );
            // var_dump($data);
            $this->Kelas_model->insert($data);
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
        $row = $this->Kelas_model->get_by_id($id);
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
            $row = $this->Kelas_model->get_by_id($this->input->post('id'));
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

            $this->Kelas_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data karyawan'));
            redirect(site_url('karyawan'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Kelas_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Kelas_model->delete($id);
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
