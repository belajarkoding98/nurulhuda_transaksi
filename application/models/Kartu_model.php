<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kartu_model extends CI_Model
{

    public $table = 'kehilangan_kartu';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }
    function cariDataNasabah($data, $like)
    {
        $this->db->select('id, id_nasabah, nps, nama_nasabah, orang_tua, kode_kelas, saldo_utama, saldo_sementara, pengeluaran')
            ->from('nasabah');
        $this->db->where($data);
        $this->db->like('orang_tua', $like, 'both'); 
        return $this->db->get();
    }
    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
    // get all data
    function get()
    {
        $this->datatables->select('id, tanggal, nps, nama_siswa, kode_kelas, orang_tua, keterangan, status, bayar, foto')
            ->from($this->table);
        return $this->datatables->generate();
    }
    function getDataKartu()
    {
        $this->db->select('id, tanggal, nps, nama_siswa, kode_kelas, orang_tua, keterangan, status, bayar, foto')
        ->from($this->table);
        return $this->db->get();
    }
    // get data by id
    function get_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get($this->table);
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
}
