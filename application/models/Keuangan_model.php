<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keuangan_model extends CI_Model
{

    public $table = 'nasabah';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    public function total($table)
    {
        $query = $this->db->get($table)->num_rows();
        return $query;
    }

    function get_maxd($pl)
    {
        $this->db->select('a.id_karyawan,a.nama_karyawan,b.nama_jabatan,d.nama_shift');
        $this->db->from('karyawan as a,jabatan as b,gedung as c,shift as d');
        $this->db->where('b.id_jabatan=a.jabatan');
        $this->db->where('a.gedung_id = c.gedung_id');
        $this->db->where('d.id_shift = a.id_shift');
        $this->db->where_in('c.gedung_id', $pl);
        return $this->db->get();
    }

    // jangan pake fungsi ini, testing query
    function get_maxe($in)
    {
        $sql =  " SELECT COUNT(id_karyawan) as total_karyawan
              FROM karyawan
              WHERE gedung_id IN ('1','2','3','4','5','6','7')
              GROUP BY gedung_id
              ORDER BY total_karyawan desc, id_karyawan
              ";

        $sql2 = " SELECT a.nama_gedung, COUNT(b.id_karyawan) as total_karyawan
              FROM karyawan as b, gedung as a
              WHERE b.gedung_id IN ('1','2','3','4','5','6','7')
              AND a.gedung_id=b.gedung_id
              GROUP BY b.gedung_id
              ORDER BY total_karyawan desc, b.id_karyawan";
        return $this->db->query($sql, $in);
        $sql3 = " CREATE view total_jabatan as
            (SELECT a.nama_jabatan, COUNT(b.id_karyawan) as total_karyawan
              FROM karyawan as b, jabatan as a
              WHERE b.jabatan IN ('1','2','3','4')
              AND a.id_jabatan=b.jabatan
              GROUP BY b.jabatan
              ORDER BY total_karyawan desc, b.id_karyawan)";

        $sql4 = "SELECT	a.nama_karyawan,b.nama_jabatan,d.nama_gedung, count(c.id_khd) as total_kehadiran
              FROM karyawan as a, jabatan as b,presensi as c,gedung as d
                where a.jabatan=b.id_jabatan
              and c.id_karyawan=a.id_karyawan
              and a.gedung_id=d.gedung_id
              GROUP BY a.id_karyawan
              ORDER BY total_kehadiran desc, a.id_karyawan";
    }

    function get_max($id)
    {
        $gi = $this->group_by_gi($id);
        $select = array('a.nama_gedung,count(b.id_karyawan) as total_karyawan');
        $this->db->select($select);
        $this->db->from('karyawan as b , gedung as a');
        $this->db->where('b.gedung_id=a.gedung_id');
        $this->db->group_by('b.gedung_id');
        $this->db->order_by('total_karyawan desc, b.id_karyawan');
        return $this->db->get();
    }

    function get_max2($in)
    {
        $select = array('a.nama_jabatan,count(b.id_karyawan) as total_karyawan');
        $this->db->select($select);
        $this->db->from('karyawan as b , jabatan as a');
        $this->db->where('b.jabatan=a.id_jabatan');
        $this->db->group_by('b.jabatan');
        $this->db->order_by('total_karyawan desc, b.id_karyawan');
        return $this->db->get();
    }

    function group_by_gi($id)
    {
        $this->db->select('gedung_id');
        $this->db->from('gedung');
        $this->db->group_by('gedung_id');
        return $this->db->get()->result_array();
    }





    function get_all_nasabah($data)
    {
        $this->db->select('id, nps, nama_nasabah, saldo_utama, saldo_sementara, pengeluaran');
        $this->db->from('nasabah');
        $this->db->where_in('nps', $data);
        return $this->db->get();
    }
    function get_all_query()
    {
        $sql = "SELECT * FROM `nasabah` JOIN siswa ON nasabah.nps=siswa.nps JOIN kelas on nasabah.kode_kelas=kelas.kode_kelas ";
        return $this->db->query($sql)->result();
    }
    function getDataNasabah()
    {
        $this->datatables->select('id, id_nasabah, nps, nama_nasabah, orang_tua, kode_kelas, saldo_utama, saldo_sementara, pengeluaran')
            ->from('nasabah');
        return $this->datatables->generate();
    }
    function getDataNasabahWhere($data)
    {
        $this->datatables->select('id, id_nasabah, nps, nama_nasabah, orang_tua, kode_kelas, saldo_utama, saldo_sementara, pengeluaran')
            ->from('nasabah');
        $this->datatables->where($data);
        return $this->datatables->generate();
    }

    function getNasabah($id)
    {
        $this->db->select('id,  id_nasabah, nps, nama_nasabah, orang_tua, kode_kelas, saldo_utama, saldo_sementara, pengeluaran, status')
            ->from('nasabah')->where('id', $id);
        return $this->db->get()->row_array();
    }
    function getDataTransaksi($id)
    {
        // $data = 'nps =' . $id;
        $this->datatables->select('id, id_transaksi, id_nasabah, nps, tanggal, kredit, debit, saldo, keperluan, keterangan')
            ->from('transaksi');
        $this->datatables->where('nps', $id);
        echo $this->datatables->generate();
    }
    function getDataTransaksiNasabah($column, $id)
    {
        // $data = 'nps =' . $id;
        $this->db->select_sum($column)
            ->from('transaksi');
        $this->db->where($id);
        $data = $this->db->get();
        // $data = $this->db->query("SELECT sum($column) FROM `transaksi` WHERE nps=$id");
        return $data;
    }
    function getDataKeperluan($id)
    {
        // $data = 'nps =' . $id;
        $this->datatables->select('transaksi.id, id_transaksi, transaksi.id_nasabah, transaksi.nps, nama_nasabah, tanggal, kredit, debit, saldo, keterangan')
            ->from('transaksi');
        $this->datatables->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        $this->datatables->where('keperluan', $id);
        echo $this->datatables->generate();
    }
    function getDataKeperluan2()
    {
        // $data = 'nps =' . $id;
        $this->datatables->select('transaksi.id, id_transaksi, transaksi.id_nasabah, transaksi.nps, nama_nasabah, tanggal, kredit, debit, saldo, keterangan')
            ->from('transaksi');
        $this->datatables->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        echo $this->datatables->generate();
    }

    public function getOneDataNasabah()
    {
        return $this->db->order_by('id', $this->order)->get_where('nasabah', 'id is not null', NULL, FALSE)->row_array();
    }

    public function getOneData()
    {
        return $this->db->order_by('id', $this->order)->get_where('nasabah', 'id is not null', NULL, FALSE)->row_array();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
    function insert_transaksi($table, $data)
    {
        $this->db->insert($table, $data);
    }
    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    function get_by_id_transaksi($table, $id)
    {
        $this->db->where('id_transaksi', $id);
        return $this->db->get($table)->row();
    }
    function get_by_edittransaksi($id)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        $this->db->where('id_transaksi', $id);
        return $this->db->get()->row();
    }
    // get data by id_nasabah
    function get_by_idnasabah($id)
    {
        $this->db->where('nps', $id);
        return $this->db->get($this->table)->row();
    }
    function get_by_pengeluaran($id)
    {
        $this->db->select('pengeluaran');
        $this->db->where('nps', $id);
        return $this->db->get($this->table)->row();
    }
    function get_by_idtransaksi($table, $id)
    {
        $this->db->where('nps', $id);
        $this->db->order_by('id_transaksi', 'desc');
        return $this->db->get($table)->row();
    }
    function get_by_idtransaksi_where($table, $data)
    {
        $this->db->where($data);
        $this->db->order_by('id_transaksi', 'desc');
        return $this->db->get($table)->row();
    }
    function get_by_query($id)
    {
        return $this->db->query('SELECT * FROM (SELECT * from transaksi WHERE nps="$id" ORDER BY id_transaksi DESC LIMIT 2) transaksi ORDER by id_transaksi limit 1')->row();
    }
    function get_by_kredit($id)
    {
        $this->db->select('*')
            // ->join('transaksi', 'nasabah.nps=transaksi.nps')
            ->where('nps', $id);
        return $this->db->get($this->table)->row();
    }
    function get_by_debit($id)
    {
        $this->db->select('*')
            // ->join('transaksi', 'nasabah.nps=transaksi.nps')
            ->where('nps', $id);
        return $this->db->get($this->table)->row();
    }
    // function get_by_nps($id)
    // {
    //     $this->db->where('nps', $id);
    //     return $this->db->get($this->table)->row();
    // }
    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
    function update_transaksi($id, $data)
    {
        $this->db->where('id_transaksi', $id);
        $this->db->update('transaksi', $data);
    }

    // update data
    function updateNominal($id, $data)
    {
        $this->db->where('nps', $id);
        $this->db->update($this->table, $data);
    }
    function get_by_nps($id)
    {
        $this->db->where('nps', $id);
        return $this->db->get($this->table)->row();
    }
    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
    function deletetransaksi($table, $id, $id2)
    {
        $this->db->where($id2, $id);
        $this->db->delete($table);
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
    public function insert_multiple($table, $data)
    {
        $this->db->insert_batch($table, $data);
    }

    public function update_multiple($table, $data, $id)
    {
        $this->db->update_batch($table, $data, $id);
    }

    public function QueryExist($id){
        return $this->db->query("select exists(select 1 from nasabah where nps='".$id."')");
    }
}
