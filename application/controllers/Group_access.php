<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_access extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_group_access');
	}

	public function index()
	{
		$data['data'] = [];
		$this->theme('group_access/index',$data);
	}

	public function save()
	{
		$data = $this->input->post();

		if ($this->m_group_access->validation()) {
			if ($data['id']) {
				$this->db->where('id',$data['id'])->update('group_access',$data);
			}else{
				unset($data['id']);
				$this->db->insert('group_access',$data);
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
		redirect('group_access');

	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_group_access->get_column();
		$data 	= $this->datatable->get_data($fields,$filter = array(),'m_group_access',$attr);
		$records["aaData"] = array();
		$no   	= 1 + $attr['start']; 
        foreach ($data['dataku'] as $index=>$row) { 
      
		 	$action ='	<button onclick="set_val(\''.$row['id_key'].'\')" class="btn btn-xs btn-info" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </button>';

           	$action .='	<button href="javascript:void(0)" onclick="deleteRow(\''.$row['id_key'].'\')" class="btn btn-xs  btn-danger" title="Delete">
							<i class="fa fa-trash-o"></i>
                        </button>';
            $obj = array($no);
            foreach ($fields as $key => $value) {
            	$obj[] = $row[$value];
            }
            $obj[] = $action;
            $records["aaData"][] = $obj;
            $no++;
        }
        $data = array_merge($data,$records);
        unset($data['dataku']);
        echo json_encode($data);
	}

	public function find_one($id)
	{
		$data = $this->db->where('id',$id)->get("group_access")->row();

		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('id',$id)->delete("group_access");
		$resp = array();
		if ($this->db->affected_rows()) {
			$resp['message'] = 'Data berhasil dihapus';
		}else{
			$err = $this->db->error();
			$resp['message'] = $err['message'];
		}
		echo json_encode($resp);
	}

	public function show_form()
	{
		$this->load->view("group_access/form");
	}
}
