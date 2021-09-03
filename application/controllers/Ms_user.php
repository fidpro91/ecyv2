<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ms_user extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_ms_user');
	}

	public function index()
	{
		$data['data'] = [];
		$this->theme('ms_user/index',$data);
	}

	public function save()
	{
		$data = $this->input->post();
		$data['user_salt_encrypt'] = md5($data['user_password']);
		if ($this->m_ms_user->validation()) {
			if ($data['user_id']) {
				$this->db->where('user_id',$data['user_id'])->update('ms_user',$data);
			}else{
				unset($data['user_id']);
				$this->db->insert('ms_user',$data);
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
		redirect('ms_user');

	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_ms_user->get_column();
		$data 	= $this->datatable->get_data($fields,$filter = array(),'m_ms_user',$attr);
		$records["aaData"] = array();
		$no   	= 1 + $attr['start']; 
        foreach ($data['dataku'] as $index=>$row) { 
      
		 	$action ='	<button onclick="set_val(\''.$row['user_id'].'\')" class="btn btn-xs btn-info" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </button>';

           	$action .='	<button href="javascript:void(0)" onclick="deleteRow(\''.$row['user_id'].'\')" class="btn btn-xs  btn-danger" title="Delete">
							<i class="fa fa-trash-o"></i>
                        </button>';
            $obj = array($row['user_id'],$no);
            foreach ($fields as $key => $value) {
            	if (is_array($value)) {
            		if (isset($value['custom'])){
            			$obj[] = call_user_func($value['custom'],$row[$key]);
            		}else{
            			$obj[] = $row[$key];
            		}
            	}else{
            		$obj[] = $row[$value];
            	}
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
		$data = $this->db->where('user_id',$id)->get("ms_user")->row();

		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('user_id',$id)->delete("ms_user");
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
			$this->db->where('user_id',$value)->delete("ms_user");
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
		$this->load->view("ms_user/form");
	}
}
