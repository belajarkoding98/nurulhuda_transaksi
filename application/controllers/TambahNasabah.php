<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TambahNasabah extends CI_Controller
{

    private $filename; // Kita tentukan nama filenya

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Keuangan_model', 'Siswa_model'));
        $this->load->library('form_validation', 'ion_auth');
        $this->load->helper('url');
        $this->user = $this->ion_auth->user()->row();
    }

    function get_siswa()
    {
        $nps = $this->input->post('nps');
        if ($nps) {
            $row =  $this->Siswa_model->getOneDataSiswa($nps);
        }

        echo json_encode($row, false);
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }
}
