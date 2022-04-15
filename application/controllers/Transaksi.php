<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Keuangan_model', 'Jabatan_model', 'laporan_model'));
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
        $nasabah = $this->Keuangan_model->get_all_query();
        $data = array(
            'nasabah_data' => $nasabah,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        // var_dump($nasabah);
        $this->template->load('template/template', 'keuangan/laporan/transaksi_laporan', $data);
        $this->load->view('template/datatables', $data);
    }

   
    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {
        $this->output_json($this->laporan_model->read(), false);
    }

    public function create_action()
    {
        $nps = $this->input->post('nps', TRUE);
        $nominal = $this->input->post('nominal', TRUE);
        $cek = $this->Keuangan_model->get_by_nps($nps);
        var_dump($cek);
        $saldo = $cek->saldo;
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Gagal mengurangi saldo'));
            redirect(site_url('transaksi'));
        } else {
            $saldo_akhir = (int) $saldo - (int) $nominal;
            $data = array(
                'saldo' => $saldo_akhir,
            );
            $this->Keuangan_model->updateNominal($nps, $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil mengurangi saldo' . $saldo));
            redirect(site_url('transaksi'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nominal', 'nominal', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
