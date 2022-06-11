<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Nasabah extends CI_Controller
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
        $this->template->load('template/template', 'keuangan/nasabah/nasabah_list', $data);
        $this->load->view('template/datatables', $data);
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    // public function carikelas($id)
    // {
    //     $data_kelas = ['kode_kelas' => $id];
    //     $this->output_json($this->Keuangan_model->getDataNasabahWhere($data_kelas), false);
    // }
    public function data()
    {
        $kode_kelas = $this->input->post('kode_kelas');
        // if($kode_kelas == ""){
            $this->output_json($this->Keuangan_model->getDataNasabah(), false);
        // }else{
        //     $data_kelas = ['kode_kelas' => $kode_kelas];
        // $this->output_json($this->Keuangan_model->getDataNasabahWhere($data_kelas), false);
        // }
    }

    public function detaildata()
    {
        $id = $this->input->post('id');
        // $id = $this->uri->segment(3);
        // $id = '52220210001';
        // var_dump($id);
        $this->output_json($this->Keuangan_model->getDataTransaksi($id), false);
    }

    public function rd($id)
    {
        $user = $this->user;
        $row = $this->Keuangan_model->get_by_id_query($this->uri->segment(3));

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
        $cek_urutan = $this->Keuangan_model->getOneDataNasabah();
        if ($cek_urutan != null) {
            $urutan = substr($cek_urutan['id_nasabah'], -4);
            $urutan++;
            $no = str_pad($urutan, 4, "0", STR_PAD_LEFT);
            $id_nasabah =  'NH' . date('ymd')  . $no;
        } else {
            $id_nasabah = 'NH' . date('ymd') . '0001';
        }

        $user = $this->user;
        $data = array(
            'title' => 'FORMULIR TAMBAH NASABAH',
            'box' => 'success',
            'button' => '<i
        class="fa fa-save"></i> &nbsp;&nbsp;Simpan',
            'action' => 'nasabah/create_action',
            'id' => set_value('id'),
            'id_nasabah' => $id_nasabah,
            'nps' => set_value('nps'),
            'orang_tua' => set_value('orang_tua'),
            'nama_siswa' => set_value('nama_nasabah'),
            'kode_kelas' => set_value('kode_kelas'),
            'status' => set_value('status'),
            'saldo_utama' => set_value('saldo_utama'),
            'saldo_sementara' => set_value('saldo_sementara'),
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
        );
        $this->template->load('template/template', 'keuangan/nasabah/nasabah_form', $data);
    }
    public function create_action()
    {
        $nps = $this->input->post('nps', TRUE);
        $cek_urutan = $this->Keuangan_model->getOneDataNasabah();
        $cek_siswa = $this->Siswa_model->getOneDataWhere($nps);
        var_dump($cek_siswa);
        $id = $cek_urutan['id'];
        $id++;
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'id' => $id,
                'id_nasabah' => $this->input->post('id_nasabah', TRUE),
                'nps' => $nps,
                'nama_nasabah' => $cek_siswa['nama_siswa'],
                'orang_tua' => 'Ecih Sunengsih',
                'kode_kelas' => $this->input->post('kode_kelas', TRUE),
                'saldo' => 0,
            );
            $this->Keuangan_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan siswa'));
            redirect(site_url('nasabah'));
        }
    }


    public function create_kredit()
    {
        $nps = $this->input->post('nps', TRUE);
        $id_transaksi = $this->input->post('id_transaksi', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);
        $totalbayar = str_replace('Rp.', '', $this->input->post('kredit', TRUE));
        $kredit = str_replace('.', '', $totalbayar);

        $d_kredit = array('nps' => $nps, 'keperluan' => 'setoran');
        $d_debit = array('nps' => $nps);
        $cek_kredit = $this->Keuangan_model->getDataTransaksiNasabah('kredit', $d_kredit)->row();
        $cek_debit = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_debit)->row();
        if($cek_kredit && $cek_debit){
            $saldo = (int)$cek_kredit->kredit - (int)$cek_debit->debit + (int)$kredit;
        }else{
            $saldo = (int)$cek_kredit->kredit + (int)$kredit;
        }

        $this->_ruleskredit();
        if ($this->form_validation->run() == FALSE) {
            // $this->setoran_nasabah($nps);
            redirect(base_url('setoran_nasabah/' . $nps));
        } else {
            $data = array(
                'id_transaksi' => $id_transaksi,
                'id_nasabah' => $this->input->post('id_nasabah', TRUE),
                'nps' => $nps,
                'tanggal' => date('y-m-d H:i:s'),
                'kredit' => $kredit,
                'debit' => '0',
                'saldo' => $saldo,
                'keperluan' => 'setoran',
                'keterangan' => $keterangan,
            );
            //tambah saldo utama
            $this->Keuangan_model->updateNominal($nps, ['saldo_utama' => $saldo]);

            $this->Keuangan_model->insert_transaksi('transaksi', $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan Setoran'));
            redirect(site_url('transaksi_nasabah/' . $nps));
        }
    }

    public function create_debit()
    {
        $nps = $this->input->post('nps', TRUE);
        $id_transaksi = $this->input->post('id_transaksi', TRUE);
        $keperluan = $this->input->post('keperluan', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);
        $totalbayar = str_replace('Rp.', '', $this->input->post('debit', TRUE));
        $debit = str_replace('.', '', $totalbayar);
        
        $d_kredit = array('nps' => $nps, 'keperluan' => 'setoran');
        $d_debit = array('nps' => $nps);
        $cek_kredit = $this->Keuangan_model->getDataTransaksiNasabah('kredit', $d_kredit)->row();
        $cek_debit = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_debit)->row();
        if($cek_kredit && $cek_debit){
            $saldo = (int)$cek_kredit->kredit - (int)$cek_debit->debit - (int)$debit;
        }else{
            $saldo = (int)$cek_kredit->kredit - (int)$debit;
        }

        $this->_rulesdebit();
        if ($this->form_validation->run() == FALSE) {
            // $this->setoran_nasabah($nps);
            redirect(base_url('setoran_nasabah/' . $nps));
        } else {
            $data = array(
                'id_transaksi' => $id_transaksi,
                'id_nasabah' => $this->input->post('id_nasabah', TRUE),
                'nps' => $nps,
                'tanggal' => date('y-m-d H:i:s'),
                'kredit' => '0',
                'debit' => $debit,
                'saldo' => $saldo,
                'keperluan' => $keperluan,
                'keterangan' => $keterangan,
            );
            if ($keperluan == "jajan" || $keperluan == "pribadi") {
                //ambil data sementara
                $cek_saldo_s = $this->Keuangan_model->get_by_nps($nps);
                if ($cek_saldo_s) {
                    $saldo_s = $cek_saldo_s->saldo_sementara + $debit;
                } else {
                    $saldo_s = $debit;
                }
                //tambah saldo utama
                $this->Keuangan_model->updateNominal($nps, ['saldo_utama' => $saldo, 'saldo_sementara' => $saldo_s]);
            } else {
                $this->Keuangan_model->updateNominal($nps, ['saldo_utama' => $saldo]);
            }

            $this->Keuangan_model->insert_transaksi('transaksi', $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil melakukan Penarikan Tunai'));
            redirect(site_url('transaksi_nasabah/' . $nps));
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

    public function import_nasabah()
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
        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import', $data);
    }

    public function import_setoran()
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
        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import_setoran', $data);
    }

    public function import_saldo()
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
        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import_saldo', $data);
    }

    public function import_kas_galon()
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
        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import_kas_galon', $data);
    }

    public function import_lainnya()
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
        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import_lainnya', $data);
    }

    public function editnasabah($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $user = $this->user;
        $nasabah = $this->Keuangan_model->get_by_kredit($id);
        $row = $this->Keuangan_model->getNasabah($id);
        // var_dump($row);
        if ($row) {
            $data = array(
                'title' => 'FORMULIR UPDATE NASABAH',
                'box' => 'warning',
                'button' => '<i
            class="fa fa-upload"></i> &nbsp;&nbsp;Update',
                'action' => 'nasabah/update_nasabah',
                'id' => $row['id'],
                'id_nasabah' => $row['id_nasabah'],
                'nps' => $row['nps'],
                'orang_tua' => $row['orang_tua'],
                'nama_siswa' => $row['nama_nasabah'],
                'kode_kelas' => $row['kode_kelas'],
                'status' => $row['status'],
                'saldo_utama' => $row['saldo_utama'],
                'saldo_sementara' => $row['saldo_sementara'],
                'pengeluaran' => $row['pengeluaran'],
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );

            $this->template->load('template/template', 'keuangan/nasabah/nasabah_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('nasabah'));
        }
    }


    public function update_nasabah()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $this->_rulesNasabah();
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('nasabah/' . $this->input->post('nps', TRUE)));
        } else {
            $cek_saldo = $this->Keuangan_model->get_all_nasabah($this->input->post('nps', TRUE))->row_array();
            //hilangkan format Rp
            $saldo_utama = $this->removeRp($this->input->post('saldo_utama', TRUE));
            $saldo_sementara = $this->removeRp($this->input->post('saldo_sementara', TRUE));
            $pengeluaran = $this->removeRp($this->input->post('pengeluaran', TRUE));
            $saldo_u = (int)$saldo_utama - (int)$saldo_sementara;
            $data = array(
                'nama_nasabah' => $this->input->post('nama_siswa', TRUE),
                'orang_tua' => $this->input->post('orang_tua', TRUE),
                'kode_kelas' => $this->input->post('kode_kelas', TRUE),
                'saldo_utama' => $saldo_utama,
                'saldo_sementara' => $saldo_sementara,
                'pengeluaran' => $pengeluaran,
            );

            // if ($saldo_utama != $cek_saldo['saldo_utama'] && $saldo_sementara != $cek_saldo['saldo_sementara']) {
            //     $data['saldo_utama'] = $saldo_u;
            //     $data['saldo_sementara'] = $saldo_sementara;
            // } else {
            //     $data['saldo_utama'] = $saldo_u;
            //     $data['saldo_sementara'] = $saldo_sementara;
            // }
            var_dump($data);
            $this->Keuangan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil Merubah Data Nasabah'));
            redirect(site_url('nasabah'));
        }
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
                'action' => site_url('siswa/update_action'),
                // 'nama_siswa' => set_value('nama_siswa', $row->nama_siswa),
                'id_nasabah' => set_value('nama_siswa', $row->nama_siswa),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
                'id' => set_value('id', $row->id),
            );
            $this->template->load('template/template', 'keuangan/nasabah/nasabah_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('nasabah'));
        }
    }

    public function edittransaksi($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $chek = $this->ion_auth->is_admin();
        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $nasabah = $this->Keuangan_model->get_by_kredit($id);
        $row = $this->Keuangan_model->get_by_edittransaksi($id);

        if ($row) {
            $data = array(
                'box' => 'danger',
                'button' => '<i
            class="fa fa-upload fa-2x"></i> &nbsp;&nbsp;Update',
                'nasabah' => $row,
                'id_transaksi' => $row->id_transaksi,
                'result' => $hasil,
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            if ($row->kredit == 0) {
                $data['debit'] = $row->debit;
                $data['saldo'] = $row->saldo;
                $data['keterangan'] = $row->keterangan;
                $data['action'] = "update_debit";
                $data['keperluan'] = $row->keperluan;
                $this->template->load('template/template', 'keuangan/nasabah/nasabah_debit_form', $data);
                $this->load->view('template/datatables', $data);
            } else {
                $data['kredit'] = $row->kredit;
                $data['saldo'] = $row->saldo;
                $data['keterangan'] = $row->keterangan;
                $data['action'] = "update_kredit";
                $this->template->load('template/template', 'keuangan/nasabah/nasabah_kredit_form', $data);
                $this->load->view('template/datatables', $data);
            }
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi_nasabah/'));
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
            $row = $this->Keuangan_model->get_by_id($this->input->post('id'));
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

            $this->Keuangan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data siswa'));
            redirect(site_url('siswa'));
        }
    }

    //ga usah update
    public function update_kredit()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        } else {
        }
        $nps = $this->input->post('nps', TRUE);
        $id_transaksi = $this->input->post('id_transaksi', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);
        $kredit = $this->removeRp($this->input->post('kredit', TRUE));
        $saldo = $this->removeRp($this->input->post('saldo', TRUE));
        // $cek_transaksi = $this->Keuangan_model->get_by_idtransaksi_where('transaksi', ['id_transaksi' => $id_transaksi]);
        // if ($cek_transaksi != null) {
        //     $id_t = $cek_transaksi->saldo;
        //     $kredit_sementara = $cek_transaksi->kredit;
        // } else {
        //     $kredit_sementara = 0;
        //     $id_t = 0;
        // }

        // $saldo = ($id_t - $kredit_sementara) + $kredit;
        // var_dump($cek_transaksi);
        $this->_ruleskredit();
        if ($this->form_validation->run() == FALSE) {
            // $this->setoran_nasabah($nps);
            redirect(base_url('setoran_nasabah/' . $nps));
        } else {
            $data = array(
                'kredit' => $kredit,
                'saldo' => $saldo,
                'keperluan' => 'setoran',
                'keterangan' => $keterangan,
            );

            // var_dump($data);
            $this->Keuangan_model->update_transaksi($id_transaksi, $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah Setoran'));
            redirect(site_url('transaksi_nasabah/' . $nps));
        }
    }

    //ga usah update
    public function update_debit()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }


        $nps = $this->input->post('nps', TRUE);
        $id_transaksi = $this->input->post('id_transaksi', TRUE);
        $keperluan = $this->input->post('keperluan', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);
        $debit = $this->removeRp($this->input->post('debit', TRUE));
        $saldo = $this->removeRp($this->input->post('saldo', TRUE));

        

        // $saldo = (int)$cek_debit->debit - (int)$cek_kredit->kredit;
        // var_dump($cek_transaksi);
        $this->_rulesdebit();
        if ($this->form_validation->run() == FALSE) {
            // $this->setoran_nasabah($nps);
            redirect(base_url('setoran_nasabah/' . $nps));
        } else {
            $data = array(
                'debit' => $debit,
                'keperluan' => $keperluan,
                'saldo' => $saldo,
                'keterangan' => $keterangan,
            );

            // var_dump($cek_kredit);
            $this->Keuangan_model->update_transaksi($id_transaksi, $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah Penarikan'));
            redirect(site_url('transaksi_nasabah/' . $nps));
        }
    }

    public function topup()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        // $this->_rules();
        // if ($this->form_validation->run() == FALSE) {
        //     // $this->update($this->input->post('saldo', TRUE));
        //     redirect(site_url('nasabah'));
        // } else {
        $nps = $this->input->post('nps');
        $saldo_sblm = $this->input->post('saldosebelumnya');
        $saldo_ditambah = $this->input->post('saldoditambah');
        $saldo = (int)$saldo_sblm + (int)$saldo_ditambah;
        $kode = $this->Keuangan_model->get_by_nps($nps);
        $data = array(
            'saldo' => $saldo,
        );

        $this->Keuangan_model->updateNominal($nps, $data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil Topup data'));
        redirect(site_url('nasabah'));
        // }
    }

    function edit_modal()
    {
        $id = $this->uri->segment(3);
        $e = $this->db->where('id', $id)->get('nasabah')->row();

        $kirim['id'] = $e->id_profile;

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($kirim));
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Keuangan_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Keuangan_model->delete($id);
            $this->Keuangan_model->deletetransaksi('transaksi', $row->nps, 'nps');
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data siswa'));
            redirect(site_url('nasabah'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('nasabah'));
            // redirect(site_url('siswa'));
        }
    }

    public function deletetransaksi($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Keuangan_model->get_by_id_transaksi('transaksi', $this->uri->segment(3));
        $nps = $row->nps;
        // var_dump($row);
        if ($row) {
            //ambil saldo utama/sementara
            $nasabah = $this->Keuangan_model->get_by_idnasabah($row->nps);
            $d_kredit = array('nps' => $nps, 'keperluan' => 'setoran');
            $d_debit = array('nps' => $nps);
            $cek_kredit = $this->Keuangan_model->getDataTransaksiNasabah('kredit', $d_kredit)->row();
            $cek_debit = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_debit)->row();

            if($cek_kredit && $cek_debit){
                $saldo = (int)$cek_kredit->kredit - (int)$cek_debit->debit + (int)$row->debit;
            }else{
                $saldo = (int)$cek_kredit->kredit + (int)$row->debit;
            }
            
            if ($row->kredit == 0) {
                // var_dump($cek_kredit->kredit);
                // $saldo = ($row->debit) + ($nasabah->saldo_utama); //salah disini    
                //hanya hapus jajan dan pribadi
                if($row->keperluan == "jajan" || $nasabah->keperluan == "pribadi"){
                    $saldo_s = ($nasabah->saldo_sementara) - ($row->debit); //kurangi saldo sementara
                    $this->Keuangan_model->updateNominal($row->nps, ['saldo_utama' => $saldo, 'saldo_sementara' => $saldo_s]);
                }else{
                    $this->Keuangan_model->updateNominal($row->nps, ['saldo_utama' => $saldo]);
                }
            } else {
                if($row->keperluan == "setoran"){
                    $saldo_u = ($nasabah->saldo_utama) - ($row->kredit); //kurangi saldo sementara
                    $this->Keuangan_model->updateNominal($row->nps, ['saldo_utama' => $saldo_u]);
                }else{
                }
            }
            $this->Keuangan_model->deletetransaksi('transaksi', $id, 'id_transaksi');
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data'));
            redirect(site_url('transaksi_nasabah/' . $row->nps));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('transaksi_nasabah/' . $row->nps));
            // redirect(site_url('siswa'));
        }
    }

    public function transaksi_nasabah($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $chek = $this->ion_auth->is_admin();

        //sum saldo
        $d_kredit = array('nps' => $id, 'keperluan' => 'setoran');
        $d_debit = array('nps' => $id);
        $cek_kredit = $this->Keuangan_model->getDataTransaksiNasabah('kredit', $d_kredit)->row();
        $cek_debit = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_debit)->row();

        $saldo = $cek_kredit->kredit - $cek_debit->debit;

        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $row = $this->Keuangan_model->get_by_idnasabah($id);

        if ($row) {
            $data = array(
                'user' => $user, 'users'     => $this->ion_auth->user()->row(),
                'nasabah' => $row->nama_nasabah,
                'nps' => $row->nps,
                'result' => $hasil,
                'saldo' => $saldo,
            );
            $this->template->load('template/template', 'keuangan/nasabah/nasabah_transaksi', $data);
            $this->load->view('template/datatables', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('nasabah'));
        }
        // $this->template->load('template/template', 'keuangan/nasabah/nasabah_transaksi', $id);
    }

    public function setoran_nasabah($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $chek = $this->ion_auth->is_admin();
        // $id = $this->uri->segment(2);
        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $row = $this->Keuangan_model->get_by_kredit($id);
        $data = array(
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'nasabah' => $row,
            'result' => $hasil,
            'id_transaksi' => date('ymdHis'),
            'kredit' => '',
            'keterangan' => '',
            'action' => "create_kredit",
            'button' => '<i
            class="fa fa-save fa-2x"></i> &nbsp;&nbsp;Simpan',
        );
        // var_dump($row);
        $this->template->load('template/template', 'keuangan/nasabah/nasabah_kredit', $data);
        $this->load->view('template/datatables', $data);
    }

    public function penarikan_nasabah($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $chek = $this->ion_auth->is_admin();
        // $id = $this->uri->segment(2);
        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $row = $this->Keuangan_model->get_by_debit($id);
        $data = array(
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'nasabah' => $row,
            'result' => $hasil,
            'id_transaksi' => date('ymdHis'),
            'debit' => '',
            'keperluan' => '',
            'keterangan' => '',
            'action' => "create_debit",
            'button' => '<i
            class="fa fa-save fa-2x"></i> &nbsp;&nbsp;Simpan',
        );
        // var_dump($row);
        $this->template->load('template/template', 'keuangan/nasabah/nasabah_debit', $data);
        $this->load->view('template/datatables', $data);
    }


    public function _rules()
    {
        $this->form_validation->set_rules('id_nasabah', 'id nasabah', 'trim|required');
        $this->form_validation->set_rules('nps', 'nps', 'trim|required');
        $this->form_validation->set_rules('kode_kelas', 'Kode Kelas', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function _rulesNasabah()
    {
        $this->form_validation->set_rules('kode_kelas', 'Kode Kelas', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('saldo_utama', 'saldo_utama', 'trim|required');
        $this->form_validation->set_rules('saldo_sementara', 'saldo_sementara', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _ruleskredit()
    {
        $this->form_validation->set_rules('kredit', 'kredit', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rulesdebit()
    {
        $this->form_validation->set_rules('debit', 'debit', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
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
        $this->load->library('ciqrcode');
        $this->load->model('GenBar_model');
        $car = $this->Keuangan_model->getShow_query($id);
        if ($car->num_rows() > 0) {
            foreach ($car->result() as $row) {
                $shows = array(
                    'nps' => $row->nps,
                    'nama_siswa' => $row->nama_siswa,
                    'jk' => $row->jk,
                    'tempat_lahir' => $row->tempat_lahir,
                    'tgl_lahir' => $row->tgl_lahir,
                    'kelas' => $row->kelas
                );
                $this->load->view('siswa/ambilqr/v_scan', $shows);
            }
        } else {
            $this->load->view('siswa/ambilqr/v_scan_kosong');
        }
    }

    public function form()
    {
        // $this->filename = "data" . date('Ymd');
        // $data = array(); // Buat variabel $data sebagai array

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

        if (isset($_POST['preview'])) {
            $tgl_sekarang = date('Ymd'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
            $nama_file_baru = 'import_data_nasabah' . $tgl_sekarang . '.xlsx';
    
            // Cek apakah terdapat file data.xlsx pada folder tmp
            // if (is_file('excel/' . $nama_file_baru)) // Jika file tersebut ada
                // unlink('excel/' . $nama_file_baru); // Hapus file tersebut
    
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];
    
            // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
            if ($ext == "xlsx") {
                // Upload file yang dipilih ke folder tmp
                // dan rename file tersebut menjadi data{tglsekarang}.xlsx
                // {tglsekarang} diganti jadi tanggal sekarang dengan format yyyymmddHHiiss
                // Contoh nama file setelah di rename : data20210814192500.xlsx
                move_uploaded_file($tmp_file, 'excel/' . $nama_file_baru);
    
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load('excel/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
                $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $data['sheet'] = $sheet;
                $data['nama_file_baru'] = $nama_file_baru;
            } else { // Jika proses upload gagal
                $data['upload_error'] = $tmp_file['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
                $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Data Gagal di Preview'));
            }
        }

        // redirect(site_url('siswa/tambah_siswa'));
        // $this->load->view('siswa/siswa_import', $data);

        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import', $data);
    }

    public function form_import()
    {
        // $this->filename = "data" . date('Ymd');
        // $data = array(); // Buat variabel $data sebagai array

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

        if (isset($_POST['preview'])) {
            $tgl_sekarang = date('Ym'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
            $nama_file_baru = 'import_data_saldo' . $tgl_sekarang . '.xlsx';
    
            // Cek apakah terdapat file data.xlsx pada folder tmp
            // if (is_file('excel/' . $nama_file_baru)) // Jika file tersebut ada
                // unlink('excel/' . $nama_file_baru); // Hapus file tersebut
    
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];
    
            // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
            if ($ext == "xlsx") {
                // Upload file yang dipilih ke folder tmp
                // dan rename file tersebut menjadi data{tglsekarang}.xlsx
                // {tglsekarang} diganti jadi tanggal sekarang dengan format yyyymmddHHiiss
                // Contoh nama file setelah di rename : data20210814192500.xlsx
                move_uploaded_file($tmp_file, 'excel/' . $nama_file_baru);
    
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load('excel/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
                $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $data['sheet'] = $sheet;
                $data['nama_file_baru'] = $nama_file_baru;
            } else { // Jika proses upload gagal
                $data['upload_error'] = $tmp_file['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
                $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Data Gagal di Preview'));
            }
        }

        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import_saldo', $data);
    }

    public function form_import_setoran()
    {
        // $this->filename = "data" . date('Ymd');
        // $data = array(); // Buat variabel $data sebagai array

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

        if (isset($_POST['preview'])) {
            $tgl_sekarang = date('Ym'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
            $nama_file_baru = 'import_data_setoran' . $tgl_sekarang . '.xlsx';
    
            // Cek apakah terdapat file data.xlsx pada folder tmp
            // if (is_file('excel/' . $nama_file_baru)) // Jika file tersebut ada
                // unlink('excel/' . $nama_file_baru); // Hapus file tersebut
    
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];
    
            // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
            if ($ext == "xlsx") {
                // Upload file yang dipilih ke folder tmp
                // dan rename file tersebut menjadi data{tglsekarang}.xlsx
                // {tglsekarang} diganti jadi tanggal sekarang dengan format yyyymmddHHiiss
                // Contoh nama file setelah di rename : data20210814192500.xlsx
                move_uploaded_file($tmp_file, 'excel/' . $nama_file_baru);
    
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load('excel/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
                $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $data['sheet'] = $sheet;
                $data['nama_file_baru'] = $nama_file_baru;
            } else { // Jika proses upload gagal
                $data['upload_error'] = $tmp_file['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
                $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Data Gagal di Preview'));
            }
        }

        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import_setoran', $data);
    }

    public function form_kas_galon()
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
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );

        if (isset($_POST['preview'])) {
            $tgl_sekarang = date('Ym'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
            $nama_file_baru = 'import_data_kas_galon' . $tgl_sekarang . '.xlsx';
    
            // Cek apakah terdapat file data.xlsx pada folder tmp
            // if (is_file('excel/' . $nama_file_baru)) // Jika file tersebut ada
                // unlink('excel/' . $nama_file_baru); // Hapus file tersebut
    
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];
    
            // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
            if ($ext == "xlsx") {
                // Upload file yang dipilih ke folder tmp
                // dan rename file tersebut menjadi data{tglsekarang}.xlsx
                // {tglsekarang} diganti jadi tanggal sekarang dengan format yyyymmddHHiiss
                // Contoh nama file setelah di rename : data20210814192500.xlsx
                move_uploaded_file($tmp_file, 'excel/' . $nama_file_baru);
    
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load('excel/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
                $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $data['sheet'] = $sheet;
                $data['nama_file_baru'] = $nama_file_baru;
            } else { // Jika proses upload gagal
                $data['upload_error'] = $tmp_file['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
                $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Data Gagal di Preview'));
            }
        }

        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import_kas_galon', $data);
    }

    public function form_lainnya()
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
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );

        if (isset($_POST['preview'])) {
            $tgl_sekarang = date('Ym'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
            $nama_file_baru = 'import_data_lainnya' . $tgl_sekarang . '.xlsx';
    
            // Cek apakah terdapat file data.xlsx pada folder tmp
            // if (is_file('excel/' . $nama_file_baru)) // Jika file tersebut ada
                // unlink('excel/' . $nama_file_baru); // Hapus file tersebut
    
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];
    
            // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
            if ($ext == "xlsx") {
                // Upload file yang dipilih ke folder tmp
                // dan rename file tersebut menjadi data{tglsekarang}.xlsx
                // {tglsekarang} diganti jadi tanggal sekarang dengan format yyyymmddHHiiss
                // Contoh nama file setelah di rename : data20210814192500.xlsx
                move_uploaded_file($tmp_file, 'excel/' . $nama_file_baru);
    
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load('excel/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
                $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $data['sheet'] = $sheet;
                $data['nama_file_baru'] = $nama_file_baru;
            } else { // Jika proses upload gagal
                $data['upload_error'] = $tmp_file['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
                $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Data Gagal di Preview'));
            }
        }

        $this->template->load('template/template', 'keuangan/nasabah/nasabah_import_lainnya', $data);
    }

    public function import()
    {        
    if(isset($_POST['import'])){ // Jika user mengklik tombol Import
	$nama_file_baru = $_POST['namafile'];
    $path = 'excel/' . $nama_file_baru; // Set tempat menyimpan file tersebut dimana

    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load($path); // Load file yang tadi diupload ke folder tmp
    $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    
    $cek_urutan = $this->Siswa_model->getOneData();
    $id = $cek_urutan['id'];
    
    if (empty($id)) {
        $no = 0;
    } else {
        $no = $id;
    }
    $numrow = 1;
    foreach($sheet as $row){
        $id_nasabah = $row['B']; // Insert data nama dari kolom B di excel
        $nps = $row['C']; // Insert data nis dari kolom A di excel
        $nama_nasabah = $row['D']; // Insert data nis dari kolom A di excel
        $alamat = $row['E']; // Insert data nis dari kolom A di excel
        $orang_tua = $row['F']; // Insert data nis dari kolom A di excel
        $kode_kelas = $row['G']; // Insert data nis dari kolom A di excel
        $saldo_utama = (int) filter_var($row['H'], FILTER_SANITIZE_NUMBER_INT);
        $saldo_sementara = (int) filter_var($row['I'], FILTER_SANITIZE_NUMBER_INT); // Insert data nis dari kolom A di excel
        $pengeluaran = $row['J']; // Insert data alamat dari kolom D di excel
        $status = $row['K']; // Insert data alamat dari kolom D di excel

        	// Cek jika semua data tidak diisi
		if($id_nasabah == "" && $nps == "" && $nama_nasabah == "" && $alamat == "" && $orang_tua == "" && $kode_kelas == "" && $status == "")
			continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

            
            if($numrow > 1){
                $data[] = array(
                    'id_nasabah' => $row['B'], // Insert data nama dari kolom B di excel
                    'nps' => $row['C'], // Insert data nis dari kolom A di excel
                    'nama_nasabah' => $row['D'], // Insert data nis dari kolom A di excel
                    'alamat' => $row['E'], // Insert data nis dari kolom A di excel
                    'orang_tua' => $row['F'], // Insert data nis dari kolom A di excel
                    'kode_kelas' => $row['G'], // Insert data nis dari kolom A di excel
                    'saldo_utama' => (int) filter_var($row['H'], FILTER_SANITIZE_NUMBER_INT),
                    'saldo_sementara' => (int) filter_var($row['I'], FILTER_SANITIZE_NUMBER_INT), // Insert data nis dari kolom A di excel
                    'pengeluaran' => $row['J'], // Insert data alamat dari kolom D di excel
                    'status' => $row['K'], // Insert data alamat dari kolom D di excel
                );
                //create kredit
                $data_kredit[] = array(
                    'id_transaksi' => date('ymdHis') . $row['A'],
                    'id_nasabah' => $row['B'],
                    'nps' => $row['C'],
                    'tanggal' => date('y-m-d H:i:s'),
                    'kredit' => (int) filter_var($row['H'], FILTER_SANITIZE_NUMBER_INT),
                    'debit' => '0',
                    'saldo' => (int) filter_var($row['H'], FILTER_SANITIZE_NUMBER_INT),
                    'keperluan' => 'setoran',
                    'keterangan' => 'Setoran Tunai' . date('d M Y'),
                );

                
            }
            $numrow++; // Tambah 1 setiap kali looping
        }
        $this->Keuangan_model->insert_multiple('transaksi', $data_kredit);

        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        $this->Keuangan_model->insert_multiple('nasabah', $data);
        // var_dump($data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Nasabah Berhasil di Import'));
        redirect("nasabah"); // Redirect ke halaman awal (ke controller siswa fungsi index)
    }
}


    public function import_data_saldo()
    {
        if(isset($_POST['import'])){ // Jika user mengklik tombol Import
            $nama_file_baru = $_POST['namafile'];
            $path = 'excel/' . $nama_file_baru; // Set tempat menyimpan file tersebut dimana
        
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($path); // Load file yang tadi diupload ke folder tmp
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
            
            
            $cek_urutan = $this->Siswa_model->getOneData();
            $id = $cek_urutan['id'];
            
            if (empty($id)) {
                $no = 0;
            } else {
                $no = $id;
            }

            for ($x = 1; $x <= count($sheet); $x++) {
                $data_nps[] =
                    $sheet[$x]['C'];
            }
    
            $cek_saldo = $this->Keuangan_model->get_all_nasabah($data_nps)->result_array();

        $i=0;
        $numrow = 1;
        foreach ($sheet as $row) {
            $no  = $row['A']; // Insert data nis dari kolom A di excel
            $id_nasabah  = $row['B']; // Insert data nasabah dari kolom B di excel
            $nps  = $row['C']; // Insert data nis dari kolom A di excel
            $kode_kelas  = $row['E'];
            $saldo_sementara  = (int) filter_var($row['F'], FILTER_SANITIZE_NUMBER_INT); // Insert data nis dari kolom A di excel
            
 	// Cek jika semua data tidak diisi
     if($no == "" && $id_nasabah == "" && $nps == ""  && $kode_kelas == "")
     continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)


            if ($numrow > 1) {
                $temp_nps = $this->Keuangan_model->QueryExist($nps)->result_array();
                if($temp_nps){
                    $d_kredit = array('nps' => $nps, 'keperluan' => 'setoran');
                    $d_debit = array('nps' => $nps);
                    $d_jajan = array('nps' => $nps, 'keperluan' => 'jajan');
                    $d_pribadi = array('nps' => $nps, 'keperluan' => 'pribadi');
                    $cek_kredit = $this->Keuangan_model->getDataTransaksiNasabah('kredit', $d_kredit)->row();
                    $cek_debit = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_debit)->row();
                    $cek_jajan = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_jajan)->row();
                    $cek_pribadi = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_pribadi)->row();

                    // var_dump($cek_kredit->kredit);
                    if($cek_debit){
                        $saldo = (int)$cek_kredit->kredit - (int)$cek_debit->debit - (int)$saldo_sementara;
                    }else{
                        $saldo = (int)$cek_kredit->kredit - (int)$saldo_sementara;
                    }

                    $cek_pengeluaran = $this->Keuangan_model->get_by_pengeluaran($nps);
                    if($cek_pengeluaran){
                        if($cek_pribadi){
                            $s_sementara = (int)$cek_jajan->debit + (int)$cek_pribadi->debit + (int)$saldo_sementara - (int)$cek_pengeluaran->pengeluaran;
                        }else if($cek_jajan){
                            $s_sementara = (int)$cek_jajan->debit + (int)$saldo_sementara - (int)$cek_pengeluaran->pengeluaran;
                        }
                    }else{
                        if($cek_pribadi){
                            $s_sementara = (int)$cek_jajan->debit + (int)$cek_pribadi->debit + (int)$saldo_sementara;
                        }else if($cek_jajan){
                            $s_sementara = (int)$cek_jajan->debit + (int)$saldo_sementara;
                        }
                    }

                    //insert data debit
                    $data_debit = array(
                        'id_transaksi' => date('ymdHis') . $no,
                        'id_nasabah' => $id_nasabah,
                        'nps' => $nps,
                        'tanggal' => date('y-m-d H:i:s'),
                        'kredit' => '0',
                        'debit' => $saldo_sementara,
                        'saldo' => $saldo,
                        'keperluan' => 'jajan',
                        'keterangan' => 'Uang Jajan ' . date('d M Y'),
                    );
                    //update data saldo
                    $data_saldo = array(
                        'nps' => $nps, // Insert data nis dari kolom A di excel
                        'kode_kelas' => $kode_kelas,
                        'saldo_utama' => (int)$saldo, // Insert data nis dari kolom A di excel
                        'saldo_sementara' => $s_sementara, // Insert data nis dari kolom A di excel
                    );

                    $this->Keuangan_model->insert_transaksi('transaksi', $data_debit);
                    $this->Keuangan_model->updateNominal($nps, $data_saldo);

                }else{

                }
            }
            if($i != $numrow -1){
                $i++;
            }
            $numrow++; // Tambah 1 setiap kali looping
            // var_dump($cek_kredit);
        }
    }

        // var_dump($saldo);
        //simpan data transaksi
        // $this->Keuangan_model->insert_multiple('transaksi', $data_debit);
        //simpan data nasabah
        // $this->Keuangan_model->update_multiple('nasabah', $data_saldo, 'nps');
        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        // var_dump($data_saldo);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Saldo Berhasil di Import'));
        redirect(site_url("nasabah")); // Redirect ke halaman awal (ke controller siswa fungsi index)

    }

    public function import_data_setoran()
    {
        if(isset($_POST['import'])){ // Jika user mengklik tombol Import
            $nama_file_baru = $_POST['namafile'];
            $path = 'excel/' . $nama_file_baru; // Set tempat menyimpan file tersebut dimana
        
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($path); // Load file yang tadi diupload ke folder tmp
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
            
            
            $cek_urutan = $this->Siswa_model->getOneData();
            $id = $cek_urutan['id'];
            
            if (empty($id)) {
                $no = 0;
            } else {
                $no = $id;
            }

            for ($x = 1; $x <= count($sheet); $x++) {
                $data_nps[] =
                    $sheet[$x]['C'];
            }
    
            $cek_saldo = $this->Keuangan_model->get_all_nasabah($data_nps)->result_array();

        $i=0;
        $numrow = 1;
        foreach ($sheet as $row) {
            $no  = $row['A']; // Insert data nis dari kolom A di excel
            $id_nasabah  = $row['B']; // Insert data nasabah dari kolom B di excel
            $nps  = $row['C']; // Insert data nis dari kolom A di excel
            $kode_kelas  = $row['E'];
            $setoran_sementara  = (int) filter_var($row['F'], FILTER_SANITIZE_NUMBER_INT); // Insert data nis dari kolom A di excel
            
 	// Cek jika semua data tidak diisi
     if($no == "" && $id_nasabah == "" && $nps == ""  && $kode_kelas == "")
     continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)


            if ($numrow > 1) {
                $temp_nps = $this->Keuangan_model->QueryExist($nps)->result_array();
                if($temp_nps){
                    $d_kredit = array('nps' => $nps, 'keperluan' => 'setoran');
                    $d_debit = array('nps' => $nps);
                    $d_jajan = array('nps' => $nps, 'keperluan' => 'jajan');
                    $d_pribadi = array('nps' => $nps, 'keperluan' => 'pribadi');
                    $cek_kredit = $this->Keuangan_model->getDataTransaksiNasabah('kredit', $d_kredit)->row();
                    $cek_debit = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_debit)->row();
                    $cek_jajan = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_jajan)->row();
                    $cek_pribadi = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_pribadi)->row();

                    // var_dump($cek_kredit->kredit);
                    if($cek_kredit){
                        $saldo_utama = ((int)$cek_kredit->kredit - (int)$cek_debit->debit ) + (int)$setoran_sementara;
                    }else{
                        $saldo_utama = (int)$cek_kredit->kredit;
                    }

                    //insert data debit
                    $data_kredit = array(
                        'id_transaksi' => date('ymdHis') . $no,
                        'id_nasabah' => $id_nasabah,
                        'nps' => $nps,
                        'tanggal' => date('y-m-d H:i:s'),
                        'kredit' => $setoran_sementara,
                        'debit' => '0',
                        'saldo' => $saldo_utama,
                        'keperluan' => 'setoran',
                        'keterangan' => 'Uang Setoran ' . date('d M Y'),
                    );
                    //update data saldo
                    $data_saldo = array(
                        'nps' => $nps, // Insert data nis dari kolom A di excel
                        'kode_kelas' => $kode_kelas,
                        'saldo_utama' => (int)$saldo_utama, // Insert data nis dari kolom A di excel
                    );

                    $this->Keuangan_model->insert_transaksi('transaksi', $data_kredit);
                    $this->Keuangan_model->updateNominal($nps, $data_saldo);

                }else{

                }
            }
            if($i != $numrow -1){
                $i++;
            }
            $numrow++; // Tambah 1 setiap kali looping
            // var_dump($cek_kredit);
        }
    }
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Saldo Berhasil di Import'));
        redirect(site_url("nasabah")); // Redirect ke halaman awal (ke controller nasabah fungsi index)

    }

    public function import_data_kas_galon()
    {
        if(isset($_POST['import'])){ // Jika user mengklik tombol Import
            $nama_file_baru = $_POST['namafile'];
            $keterangan = $_POST['keterangan'];
            $path = 'excel/' . $nama_file_baru; // Set tempat menyimpan file tersebut dimana
        
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($path); // Load file yang tadi diupload ke folder tmp
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $cek_urutan = $this->Siswa_model->getOneData();
            $id = $cek_urutan['id'];
            
            if (empty($id)) {
                $no = 0;
            } else {
                $no = $id;
            }

            for ($x = 1; $x <= count($sheet); $x++) {
                $data_nps[] =
                    $sheet[$x]['C'];
            }
    
            $cek_saldo = $this->Keuangan_model->get_all_nasabah($data_nps)->result_array();

        $i=0;
        $numrow = 1;
        foreach ($sheet as $row) {
            $no  = $row['A']; // Insert data nis dari kolom A di excel
            $id_nasabah  = $row['B']; // Insert data nasabah dari kolom B di excel
            $nps  = $row['C']; // Insert data nis dari kolom A di excel
            $kode_kelas  = $row['E'];
            $kas_galon  = (int) filter_var($row['F'], FILTER_SANITIZE_NUMBER_INT); // Insert data nis dari kolom A di excel
            
 	// Cek jika semua data tidak diisi
     if($no == "" && $id_nasabah == "" && $nps == ""  && $kode_kelas == "" && $keterangan == "")
     continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)


            if ($numrow > 1) {
                $temp_nps = $this->Keuangan_model->QueryExist($nps)->result_array();
                if($temp_nps){
                    $d_kredit = array('nps' => $nps, 'keperluan' => 'setoran');
                    $d_debit = array('nps' => $nps);
                    $cek_kredit = $this->Keuangan_model->getDataTransaksiNasabah('kredit', $d_kredit)->row();
                    $cek_debit = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_debit)->row();


                    // var_dump($cek_kredit->kredit);
                    if($cek_kredit && $cek_debit){
                        $saldo = (int)$cek_kredit->kredit - (int)$cek_debit->debit - (int)$kas_galon;
                    }else{
                        $saldo = (int)$cek_kredit->kredit - (int)$kas_galon;
                    }

                    //insert data debit
                    $data_debit = array(
                        'id_transaksi' => date('ymdHis') . $no,
                        'id_nasabah' => $id_nasabah,
                        'nps' => $nps,
                        'tanggal' => date('y-m-d H:i:s'),
                        'kredit' => '0',
                        'debit' => $kas_galon,
                        'saldo' => $saldo,
                        'keperluan' => 'kas & galon',
                        'keterangan' => $keterangan,
                    );
                    //update data saldo
                    $data_saldo = array(
                        'nps' => $nps, // Insert data nis dari kolom A di excel
                        'kode_kelas' => $kode_kelas,
                        'saldo_utama' => (int)$saldo, // Insert data nis dari kolom A di excel
                    );

                    $this->Keuangan_model->insert_transaksi('transaksi', $data_debit);
                    $this->Keuangan_model->updateNominal($nps, $data_saldo);

                }else{

                }
            }
            if($i != $numrow -1){
                $i++;
            }
            $numrow++; // Tambah 1 setiap kali looping
            // var_dump($cek_kredit);
        }
    }

        // var_dump($saldo);
        //simpan data transaksi
        // $this->Keuangan_model->insert_multiple('transaksi', $data_debit);
        //simpan data nasabah
        // $this->Keuangan_model->update_multiple('nasabah', $data_saldo, 'nps');
        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        // var_dump($data_saldo);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Kas & Galon Berhasil di Import'));
        redirect(site_url("nasabah")); // Redirect ke halaman awal (ke controller siswa fungsi index)

    }

    public function import_data_lainnya()
    {
        if(isset($_POST['import'])){ // Jika user mengklik tombol Import
            $nama_file_baru = $_POST['namafile'];
            $keterangan = $_POST['keterangan'];
            $path = 'excel/' . $nama_file_baru; // Set tempat menyimpan file tersebut dimana
        
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($path); // Load file yang tadi diupload ke folder tmp
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $cek_urutan = $this->Siswa_model->getOneData();
            $id = $cek_urutan['id'];
            
            if (empty($id)) {
                $no = 0;
            } else {
                $no = $id;
            }

            for ($x = 1; $x <= count($sheet); $x++) {
                $data_nps[] =
                    $sheet[$x]['C'];
            }
    
            $cek_saldo = $this->Keuangan_model->get_all_nasabah($data_nps)->result_array();

        $i=0;
        $numrow = 1;
        foreach ($sheet as $row) {
            $no  = $row['A']; // Insert data nis dari kolom A di excel
            $id_nasabah  = $row['B']; // Insert data nasabah dari kolom B di excel
            $nps  = $row['C']; // Insert data nis dari kolom A di excel
            $kode_kelas  = $row['E'];
            $pemotongan  = (int) filter_var($row['F'], FILTER_SANITIZE_NUMBER_INT); // Insert data nis dari kolom A di excel
            
 	// Cek jika semua data tidak diisi
     if($no == "" && $id_nasabah == "" && $nps == ""  && $kode_kelas == "" && $keterangan == "")
     continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)


            if ($numrow > 1) {
                $temp_nps = $this->Keuangan_model->QueryExist($nps)->result_array();
                if($temp_nps){
                    $d_kredit = array('nps' => $nps, 'keperluan' => 'setoran');
                    $d_debit = array('nps' => $nps);
                    $cek_kredit = $this->Keuangan_model->getDataTransaksiNasabah('kredit', $d_kredit)->row();
                    $cek_debit = $this->Keuangan_model->getDataTransaksiNasabah('debit', $d_debit)->row();


                    // var_dump($cek_kredit->kredit);
                    if($cek_kredit && $cek_debit){
                        $saldo = (int)$cek_kredit->kredit - (int)$cek_debit->debit - (int)$pemotongan;
                    }else{
                        $saldo = (int)$cek_kredit->kredit - (int)$pemotongan;
                    }

                    //insert data debit
                    $data_debit = array(
                        'id_transaksi' => date('ymdHis') . $no,
                        'id_nasabah' => $id_nasabah,
                        'nps' => $nps,
                        'tanggal' => date('y-m-d H:i:s'),
                        'kredit' => '0',
                        'debit' => $pemotongan,
                        'saldo' => $saldo,
                        'keperluan' => 'lainnya',
                        'keterangan' => $keterangan,
                    );
                    //update data saldo
                    $data_saldo = array(
                        'nps' => $nps, // Insert data nis dari kolom A di excel
                        'kode_kelas' => $kode_kelas,
                        'saldo_utama' => (int)$saldo, // Insert data nis dari kolom A di excel
                    );

                    $this->Keuangan_model->insert_transaksi('transaksi', $data_debit);
                    $this->Keuangan_model->updateNominal($nps, $data_saldo);

                }else{

                }
            }
            if($i != $numrow -1){
                $i++;
            }
            $numrow++; // Tambah 1 setiap kali looping
            // var_dump($cek_kredit);
        }
    }

        // var_dump($saldo);
        //simpan data transaksi
        // $this->Keuangan_model->insert_multiple('transaksi', $data_debit);
        //simpan data nasabah
        // $this->Keuangan_model->update_multiple('nasabah', $data_saldo, 'nps');
        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        // var_dump($data_saldo);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Lainnya Berhasil di Import'));
        redirect(site_url("nasabah")); // Redirect ke halaman awal (ke controller siswa fungsi index)

    }

    //fungsi menghilangkan format Rupiah di PHP
    function removeRp($id)
    {
        $totalbayar = str_replace('Rp.', '', $id);
        return $kredit = str_replace('.', '', $totalbayar);
    }

    public function isRowEmpty($row)
    {
        $is_row_empty = true;
        foreach ($row->getCellIterator() as $cell) {
            if ($cell->getValue() !== null && $cell->getValue() !== '') {
                $is_row_empty = false;
                break;
            }
        }

        return $is_row_empty;
    }
}
