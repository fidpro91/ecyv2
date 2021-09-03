<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_company extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_profil_company');
	}

	public function index()
	{
		$this->theme('profil_company/index');
	}

	public function save()
	{
		$data = $this->input->post();

		if ($this->m_profil_company->validation()) {
			if ($data['profil_id']) {
				$this->db->where('profil_id',$data['profil_id'])->update('profil_company',$data);
			}else{
				unset($data['profil_id']);
				$this->db->insert('profil_company',$data);
			}
			$err = $this->db->error();
			if ($err['message']) {
				$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$err['message'].'</div>');
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data berhasil disimpan</div>');
			}
		}else{
			$this->session->set_flashdata('message',validation_errors('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>','</div>'));
		}
		redirect('profil_company');

	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_profil_company->get_column();
		$data 	= $this->datatable->get_data($fields,$filter = array(),'m_profil_company',$attr);
		$records["aaData"] = array();
		$no   	= 1 + $attr['start']; 
        foreach ($data['dataku'] as $index=>$row) { 
            $obj = array($row['id_key'],$no);
            foreach ($fields as $key => $value) {
            	$obj[] = $row[$value];
            }
            $obj[] = create_btnAction(["update","delete"],$row['id_key']);
            $records["aaData"][] = $obj;
            $no++;
        }
        $data = array_merge($data,$records);
        unset($data['dataku']);
        echo json_encode($data);
	}

	public function find_one($id)
	{
		$data = $this->db->where('profil_id',$id)->get("profil_company")->row();

		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('profil_id',$id)->delete("profil_company");
		$resp = array();
		if ($this->db->affected_rows()) {
			$resp['message'] = 'Data berhasil dihapus';
		}else{
			$err = $this->db->error();
			$resp['message'] = $err['message'];
		}
		echo json_encode($resp);
	}

	public function delete_multi()
	{
		$resp = array();
		foreach ($this->input->post('data') as $key => $value) {
			$this->db->where('profil_id',$value)->delete("profil_company");
			$err = $this->db->error();
			if ($err['message']) {
				$resp['message'] .= $err['message']."\n";
			}
		}
		if (empty($resp['message'])) {
			$resp['message'] = 'Data berhasil dihapus';
		}
		echo json_encode($resp);
	}

	public function show_form()
	{
		$data['model'] = $this->m_profil_company->rules();
		$this->load->view("profil_company/form",$data);
	}
}
