<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kartu extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        // if (!$this->ion_auth->logged_in()) {
        //     redirect('auth');
        // }

        $this->load->library('user_agent');
        $this->load->model(array('Kelas_model', 'Keuangan_model', 'Jenjang_model', 'Kartu_model'));
        $this->load->library('form_validation', 'ion_auth');
        $this->load->helper(array('form', 'url'));
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
        $row_jenjang = $this->Jenjang_model->get_all_query();
        $data = array(
            'action' => site_url('kartu/create_action'),
            'kode_jenjang' => $row_jenjang,
        );
        $this->load->view('kartu/kartu_kehilangan', $data);
    }

    public function report_kartu()
    {
        $chek = $this->ion_auth->is_admin();

        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $kartu = $this->Kartu_model->getDataKartu()->result();
        $data = array(
            'kartu_data' => $kartu,
            'user' => $user, 'users' => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        // var_dump($nasabah);
        $this->template->load('template/template', 'kartu/kartu_list', $data);
        $this->load->view('template/datatables', $data);
    }

    public function create_kehilangan()
    {
        $chek = $this->ion_auth->is_admin();

        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        // $kartu = $this->Kartu_model->getDataKartu()->result();
        $data = array(
            // 'kartu_data' => $kartu,
            'user' => $user, 'users' => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        // var_dump($nasabah);
        $this->template->load('template/template', 'kartu/kartu_form', $data);
        $this->load->view('template/datatables', $data);
    }

    public function create_action()
    {
        $kode_kelas = $this->input->post('kode_kelas', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);
        $nama_lengkap = $this->input->post('nama_lengkap', TRUE);
        $orang_tua = $this->input->post('orang_tua', TRUE);
        $foto = $this->input->post('foto', TRUE);
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            // redirect(site_url('karyawab'));
            $this->index();
        } else {
            $data = array(
                'nama_nasabah' => $nama_lengkap,
                // 'kode_kelas' => $kode_kelas,
            );
            $cek_data = $this->Kartu_model->cariDataNasabah($data, $orang_tua)->row();
            if($cek_data){
                // $cek_kartu = $this->Kartu_model->get_by_nps($cek_data->nps)->row();
                // if($cek_kartu){
                //     $tmp_foto = $cek_kartu->foto;
                // }else{

                // }
                $tmp_foto = $this->upload($nama_lengkap, $kode_kelas);
            $data_kartu = [
                'nps' => $cek_data->nps,
                'tanggal' => date('Y-m-d H:i:s'),
                'nama_siswa' => $nama_lengkap,
                'kode_kelas' => $kode_kelas,
                'orang_tua' => $cek_data->orang_tua,
                'keterangan' => $keterangan,
                'foto' => $tmp_foto,
                'bayar' => 0,
                'status' => 1,
            ];
                // var_dump($data_kartu);
                $this->Kartu_model->insert($data_kartu);
                echo "<script>
                alert('Data berhasil dikirim');
                window.location.href='".base_url()."kartu';
                </script>";
            }else{
                // $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan kelas'));
                echo "<script>
                alert('Data Gagal dikirim, Pastikan Data Benar!');
                window.location.href='".base_url()."kartu';
                </script>";
            }
        }
    }

    public function update_kartu()
    {
        $status = $this->input->post('status', TRUE);
        $id = $this->input->post('id', TRUE);
        if ($status == '0') {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Status Kartu gagal diubah'));
            $this->report_kartu();
        } else {
            $data = array(
                'status' => $status,
            );
            
            // var_dump($data_kartu);   
            $this->Kartu_model->update($id, $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Status Kartu berhasil diubah'));
            redirect('kartu/report_kartu');
        }
    }

    public function upload($name, $kelas) 
    {
        $config['file_name'] = $name.'_'.$kelas;
        $config['upload_path']          = './uploads/kartu';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1000;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
 
        $this->load->library('upload', $config);
 
        if ( ! $this->upload->do_upload('foto')){
            $error = array('error' => $this->upload->display_errors());
            redirect('kartu');
        }else{
           $u_data = $this->upload->data();
            $tmp_foto = $u_data['file_name'];
            return $tmp_foto;
        }

    }

    public function bayarkartu()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        //get uang kartu dari inputan
        $uangkartu = $this->input->post('nominalkartu', TRUE);
        $id = $this->input->post('id', TRUE);
        $row = $this->Kartu_model->get_by_id($id)->row();
        $nps = $row->nps;
        $nasabah = $this->Keuangan_model->get_by_idnasabah($nps);
        if ($row) {
            //cek saldo dulu
            $d_kredit = array('nps' => $nps, 'keperluan' => 'setoran');
            $d_debit = array('nps' => $nps);
            $cek_kredit = $this->Keuangan_model->getDataTransaksiNasabah('kredit', $d_kredit)->row();
            $cek_debit = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_debit)->row();

            // var_dump($cek_kredit->kredit);
            if($cek_debit){
                $saldo = (int)$cek_kredit->kredit - (int)$cek_debit->debit - (int) filter_var($uangkartu, FILTER_SANITIZE_NUMBER_INT);
            }else{
                $saldo = (int)$cek_kredit->kredit -  (int) filter_var($uangkartu, FILTER_SANITIZE_NUMBER_INT);
            }


            $data_kredit = array(
                'id_transaksi' => date('ymdHis') . $id,
                'id_nasabah' => $nasabah->id_nasabah,
                'nps' => $nasabah->nps,
                'tanggal' => date('y-m-d H:i:s'),
                'kredit' => '0',
                'debit' => (int) filter_var($uangkartu, FILTER_SANITIZE_NUMBER_INT),
                'saldo' => $saldo,
                'keperluan' => 'lainnya',
                'keterangan' => 'Biaya Pembuatan Kartu Hilang ' . date('d M Y'),
            );
            $this->Keuangan_model->insert_transaksi('transaksi', $data_kredit);

            $data_kartu = [
                'bayar' => (int) filter_var($uangkartu, FILTER_SANITIZE_NUMBER_INT)
            ]; 
            $this->Kartu_model->update($id, $data_kartu);
            $this->Keuangan_model->updateNominal($nps, ['saldo_utama' => $saldo]);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil Bayar biaya pembuatan Kartu'));
            redirect(site_url('kartu/report_kartu'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('kartu/report_kartu'));
            // redirect(site_url('siswa'));
        }
    }
    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Kartu_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Kartu_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus Data Kehilangan Kartu'));
            redirect(site_url('nasabah'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('nasabah'));
            // redirect(site_url('siswa'));
        }
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function data()
    {
            // $nps = $this->input->post('nps');
            $this->output_json($this->Kartu_model->get(), false);
    }


    public function _rules()
    {
        $this->form_validation->set_rules('nama_lengkap', 'nama_lengkap', 'trim|required');
        $this->form_validation->set_rules('orang_tua', 'orang_tua', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}