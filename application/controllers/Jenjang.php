<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenjang extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Jenjang_model', 'Jabatan_model'));
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
        $jenjang = $this->Jenjang_model->get_all_query();
        $data = array(
            'jenjang_data' => $jenjang,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'jenjang/jenjang_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->Jenjang_model->getData(), false);
    }

    public function rd($id)
    {
        $user = $this->user;
        $row = $this->Jenjang_model->get_by_id_query($this->uri->segment(3));

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

        $user = $this->user;
        $data = array(
            'box' => 'info',
            'button' => 'Create',
            'action' => site_url('jenjang/create_action'),
            'kode_jenjang' => set_value('kode_jenjang'),
            'nama_jenjang' => set_value('nama_jenjang'),
            'id' => set_value('id'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'jenjang/jenjang_form', $data);
    }
    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'kode_jenjang' => $this->input->post('kode_jenjang', TRUE),
                'jenjang' => $this->input->post('nama_jenjang', TRUE),
            );
            var_dump($data);
            $this->Jenjang_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan jenjang'));
            redirect(site_url('jenjang'));
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
        $row = $this->Jenjang_model->get_by_id($id);
        if ($row) {
            $data = array(
                'box' => 'danger',
                'button' => 'Update',
                'action' => site_url('jenjang/update_action'),
                'kode_jenjang' => set_value('kode_jenjang', $row->kode_jenjang),
                'nama_jenjang' => set_value('nama_jenjang', $row->jenjang),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
                'id' => set_value('id', $row->id),
            );
            $this->template->load('template/template', 'jenjang/jenjang_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenjang'));
        }
    }

    public function update_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_jenjang', TRUE));
        } else {
            $kode_jenjang =  $this->input->post('kode_jenjang');
            $data = array(
                'kode_jenjang' => $kode_jenjang,
                'jenjang' => $this->input->post('nama_jenjang', TRUE),
            );
            var_dump($data);
            $this->Jenjang_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data karyawan'));
            redirect(site_url('jenjang'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Jenjang_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Jenjang_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data karyawan'));
            redirect(site_url('jenjang'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('jenjang'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('kode_jenjang', 'kode jenjang', 'trim|required');
        $this->form_validation->set_rules('nama_jenjang', 'nama jenjang', 'trim|required');
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