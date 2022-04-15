<?php

class Dashboard extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->view('template/rupiah');
		$this->load->library('user_agent');
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		}
		$this->load->model('Dashboard_model', 'dashboard');
		$this->load->model('Keuangan_model');
		$this->user = $this->ion_auth->user()->row();
	}
	public function index()
	{
		$user = $this->user;
		$data = [
			'user' 		=> $user,
			'users' 	=> $this->ion_auth->user()->row(),
		];

		if ($this->ion_auth->is_admin()) {
			$data['info_box'] = $this->admin_box();
			$plotting  = array('1', '2', '3', '4', '5', '6', '7');
			$plotting2 = array('1', '2', '3', '4');
			$data['get_plot'] = $this->dashboard->get_max($plotting)->result();
			$data['get_plot2'] = $this->dashboard->get_max2($plotting2)->result();
		}
		$data['info_box'] = $this->staff_box();
		$this->template->load('template/template', 'dashboard/dashboard', $data);
	}

	public function admin_box()
	{
		$box = [
			[
				'box' 		=> 'light-blue',
				'total' 	=> $this->dashboard->total('karyawan'),
				'title'		=> 'Karyawan',
				'icon'		=> 'user'
			],
			[
				'box' 		=> 'olive',
				'total' 	=> $this->dashboard->total('jabatan'),
				'title'		=> 'Jabatan',
				'icon'		=> 'briefcase'
			],
			[
				'box' 		=> 'yellow-active',
				'total' 	=> $this->dashboard->total('gedung'),
				'title'		=> 'lokasi',
				'icon'		=> 'building'
			],
			[
				'box' 		=> 'red',
				'total' 	=> $this->dashboard->total('shift'),
				'title'		=> 'shift',
				'icon'		=> 'retweet'
			],
		];
		$info_box = json_decode(json_encode($box), FALSE);
		return $info_box;
	}

	public function staff_box()
	{
		$box = [
			[
				'box'         => 'light-blue',
				'total'     => $this->Keuangan_model->total('siswa'),
				'title'        => 'Data Siswa',
				'size_class'        => 'col-lg-3 col-xs-6',
				'link'        => 'siswa',
				'icon'        => 'user-graduate'
			],
			[
				'box'         => 'olive',
				'total'     => $this->Keuangan_model->total('nasabah'),
				'title'        => 'Data Nasabah',
				'size_class'        => 'col-lg-3 col-xs-6',
				'link'        => 'nasabah',
				'icon'        => 'user'
			],
			[
				'box'         => 'yellow-active',
				'total'     => 'Rp. ' . rupiah($this->Keuangan_model->total('gedung')),
				'title'        => 'Saldo Hari Ini',
				'size_class'        => 'col-lg-6 col-xs-6',
				'link'        => 'nasabah',
				'icon'        => 'dollar'
			],
			[
				'box'         => 'red',
				'total'     => 'Rp. ' . rupiah($this->Keuangan_model->total('shift')),
				'title'        => 'Saldo Keseluruhan',
				'size_class'        => 'col-lg-6 col-xs-6',
				'link'        => 'nasabah',
				'icon'        => 'dollar'
			],
			[
				'box'         => 'red',
				'total'     => 'Rp. ' . rupiah($this->Keuangan_model->total('shift')),
				'title'        => 'Saldo Bulan Ini',
				'size_class'        => 'col-lg-6 col-xs-6',
				'link'        => 'nasabah',
				'icon'        => 'calendar'
			],
		];
		$info_box = json_decode(json_encode($box), FALSE);
		return $info_box;
	}

	function graph()
	{

		$data['get_plot2'] = $this->dashboard->get_max($plotting2)->result();
		$data['get_plot'] = $this->dashboard->get_max($plotting)->result();
		$get_plot = json_decode(json_encode($plotting), FALSE);
		return $get_plot;
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
