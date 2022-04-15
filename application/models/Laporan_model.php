<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan_model extends CI_Model
{


    function __construct()
    {
        parent::__construct();
        $this->db_elhuda = $this->load->database('elhuda', TRUE);
    }

    public function read()
    {
         $this->datatables->set_database('ponpesnu_elhuda');
        $this->datatables->select('transaksi.id, tanggal, barcode, total_bayar, jumlah_uang, diskon, nps, pelanggan, pembeli, nama as nama_toko')
        ->from('transaksi');
    $this->datatables->join('toko', 'toko.id_toko = transaksi.toko');
    echo $this->datatables->generate();
    }
    // public function read()
    // {
    //     $this->datatables->set_database('elhuda');
    //     $this->datatables->select('transaksi.id, tanggal, barcode, total_bayar, jumlah_uang, diskon, nps, pelanggan, pembeli, nama as nama_toko')
    //         ->from('transaksi');
    //     $this->datatables->join('toko', 'toko.id_toko = transaksi.toko');
    //     echo $this->datatables->generate();
    //     // $this->datatables->select('transaksi.id, transaksi.tanggal, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, transaksi.diskon, transaksi.nps, transaksi.pelanggan, kasir.toko.nama as nama_toko, transaksi.pembeli as nama_nasabah');
    //     // $this->datatables->from('kasir.transaksi');
    //     // return $this->datatables->generate();
    //     // return $this->datatables->generate($data);
    // }
}
