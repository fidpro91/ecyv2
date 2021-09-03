<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->datascript->lib_datepicker()
						 ->lib_morrischart();
		$this->load->model("m_dashboard");
	}

	public function index()
	{
		$data['data']=$this->m_dashboard->get_info_header();
		$this->theme('dashboard/index',$data);
	}
}