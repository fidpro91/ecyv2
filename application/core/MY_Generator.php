<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Generator extends CI_Controller
{
	protected $userData = "";
	protected $setting = array();
	public function __construct()
	{
		parent::__construct();
		$this->load->model('builder/m_builder');
		$this->load->model("get_db");
		$this->load->library('datascript');
		/* if (empty($this->session->person_name)) {
			redirect('login');
		} */
	}

	public function theme($url,$data = array(),$title='')
	{

		$header['title'] = 'Ecy Application | Home';
		$this->load->view('template/header',$header);
		$sidebar["menu"] = $this->get_db->get_menu();
		$this->load->view('template/sidebar',$sidebar);
		$this->load->view( $url, $data);
		$this->load->view('template/footer');
	}
}