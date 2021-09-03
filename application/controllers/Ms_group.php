<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ms_group extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_ms_group');
		$this->datascript->lib_jstree();
	}

	public function index()
	{
		$data['data'] = [];
		$this->theme('ms_group/index',$data);
	}

	public function save()
	{
		$data = $this->input->post();

		if ($this->m_ms_group->validation()) {
			if ($data['group_id']) {
				$this->db->where('group_id',$data['group_id'])->update('ms_group',$data);
			}else{
				unset($data['group_id']);
				$this->db->insert('ms_group',$data);
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
		redirect('ms_group');

	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_ms_group->get_column();
		$data 	= $this->datatable->get_data($fields,$filter = array(),'m_ms_group',$attr);
		$records["aaData"] = array();
		$no   	= 1 + $attr['start']; 
        foreach ($data['dataku'] as $index=>$row) { 
            $obj = array($row['id_key'],$no);
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
            $obj[] = create_btnAction(["update","delete",
            	"setting"=>[
            			"btn-act" 	=> "show_access('".$row['id_key']."')",
            			"btn-class"	=> "btn-warning",
            			"btn-icon"	=> "fa fa-gear"
            	]],$row['id_key']);
            $records["aaData"][] = $obj;
            $no++;
        }
        $data = array_merge($data,$records);
        unset($data['dataku']);
        echo json_encode($data);
	}

	public function find_one($id)
	{
		$data = $this->db->where('group_id',$id)->get("ms_group")->row();

		echo json_encode($data);
	}

	public function set_access()
	{
		$data = $this->input->post();
		$this->db->trans_begin();
		$this->db->where("group_id",$data['group_id'])->delete("group_access");
		foreach (explode(',', $data['menu_id']) as $key => $value) {
			if (empty($value)) {
				continue;
			}
			$ar_val = explode('_', $value);
			$this->db->insert("group_access",["group_id"=>$data['group_id'],"menu_id"=>$ar_val[1]]);
		}
		$err = $this->db->error();
		if ($err['message']) {
			$resp = $err['message'];
			$this->db->trans_rollback();
		}else{
			$resp['message'] = "Data berhasil disimpan";
		}	$this->db->trans_commit();
		echo json_encode($resp);
	}

	public function delete_row($id)
	{
		$this->db->where('group_id',$id)->delete("ms_group");
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
		 $data['model'] = $this->m_ms_group->rules();
		$this->load->view("ms_group/form",$data);
	}

	public function show_tree_access($id)
	{
		$this->load->view("group_access/form_tree",["group_id"=>$id]);
	}

	public function get_menu_access()
	{
		$id = $this->input->get('id');
		$group_id = $this->input->get('group_id');
		$this->load->model('m_group_access');
		echo json_encode($this->m_group_access->get_menu($id,$group_id));
	}
}
