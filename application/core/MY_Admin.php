<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Admin extends CI_Controller
{
	protected $userData = "";
	protected $setting = array();
	public function __construct()
	{
		parent::__construct();
		/*if (empty($this->session->userdata('login'))) {
			redirect('login');
		}*/
	}

	public function theme($url, $data,$title)
	{

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view( $url, $data);
		$this->load->view('template/footer');
	}
}