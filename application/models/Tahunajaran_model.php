<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tahunajaran_model extends CI_Model
{

    public $table = 'tahun_ajaran';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function get_all_query()
    {
        $sql = "SELECT * FROM `tahun_ajaran`";
        return $this->db->query($sql)->result();
    }
    function getData()
    {
        $this->datatables->select('*')
            ->from('tahun_ajaran');
        return $this->datatables->generate();
    }
    public function getOneData()
    {
        return $this->db->get_where('tahun_ajaran', 'kode_ta is not null', NULL, FALSE)->row_array();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
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