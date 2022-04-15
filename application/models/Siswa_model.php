<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Siswa_model extends CI_Model
{

    public $table = 'siswa';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }


    function get_max()
    {
        return $this->db->select('max(id) as kode')
            ->from('karyawan')->get()->result();
    }

    function get_all_query()
    {
        $sql = "SELECT * FROM `siswa` JOIN jenjang ON siswa.kode_jenjang=jenjang.kode_jenjang";
        return $this->db->query($sql)->result();
    }


    function get_by_id_query($id)
    {
        $sql = "SELECT * from Siswa where id=$id";
        return $this->db->query($sql)->row($id);
    }

    public function getOneData()
    {

        return $this->db->order_by($this->id, 'DESC')->get_where('siswa', $this->id . ' is not null', NULL, FALSE)->row_array();
    }

    public function getOneDataWhere($id)
    {

        return $this->db->get_where('siswa', 'nps=' . $id)->row_array();
    }

    public function getOneDataSiswa($id)
    {

        return $this->db->get_where('siswa', 'nps=' . $id)->row_array();
    }


    function getDataSiswa()
    {
        $this->datatables->select('siswa.id,
nps,
nim,
nisn,
nik,
no_absen,
nama_siswa,
jk,
siswa.status,
tempat_lahir,
tgl_lahir,
agama,
warga_negara,
hobi,
cita_cita,
tk,
paud,
anak_ke,
jml_saudara,
tgl_masuk,
no_hp,
tahun_ajaran,
kode_jenjang,
kelas, siswa.no_kk, nama_kepala_keluarga, nama_ayah, tempat_lahir_ayah, tgl_lahir_ayah, nik_ayah, status_ayah, pendidikan_ayah, pekerjaan_ayah,
penghasilan_ayah, no_hp_ayah, nama_ibu, tempat_lahir_ibu, tgl_lahir_ibu, nik_ibu, status_ibu, pendidikan_ibu, pekerjaan_ibu, penghasilan_ibu, no_hp_ibu, orang_tua_siswa.alamat as alamat')
            ->from('siswa')
            ->join('orang_tua_siswa', 'orang_tua_siswa.no_kk=siswa.no_kk', 'inner join')
            ->join('tahun_ajaran', 'tahun_ajaran.kode_ta=siswa.kode_ta', 'inner join');
        return $this->datatables->generate();
    }

    function getData()
    {
        $this->datatables->select('*')
            ->from('siswa');
        return $this->datatables->generate();
    }
    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }


    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    public function getshow_query($id)
    {
        $result = $this->search_value($_POST['term'] = null);
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->where('id', $id);
        $hasil = $this->db->get();
        return $hasil;
    }

    function search_value($title)
    {
        $this->db->like('nama_siswa', $title, 'both');
        $this->db->order_by('nama_siswa', 'ASC');
        $this->db->limit(10);
        return $this->db->get('siswa')->result();
    }

    public function insert_data($table, $data)
    {
        $this->db->insert($table, $data);
    }




    public function view()
    {
        return $this->db->get('siswa')->result(); // Tampilkan semua data yang ada di tabel siswa
    }

    // Fungsi untuk melakukan proses upload file
    public function upload_file($filename)
    {
        $this->load->library('upload'); // Load librari upload

        $config['upload_path'] = './excel/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size']    = '2048';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;

        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if ($this->upload->do_upload('file')) { // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    // Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
    public function insert_multiple($tabel, $data)
    {
        $this->db->insert_batch($tabel, $data);
    }
}
