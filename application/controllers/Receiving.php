<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receiving extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->datascript->lib_datepicker()
						 ->lib_inputmulti()
						 ->lib_inputmask();
		$this->load->model('m_receiving');
	}

	public function index()
	{
		$this->theme('receiving/index');
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_receiving->validation()) {
			$this->db->trans_begin();
			$input = [];
			foreach ($this->m_receiving->rules() as $key => $value) {
				$input[$key] = $data[$key];
			}
			if ($data['rec_id']) {
				$this->db->where('rec_id',$data['rec_id'])->update('receiving',$input);
			}else{
				$this->db->insert('receiving',$input);
				$data['rec_id'] = $this->db->insert_id();
				$this->insert_recdet($data);
			}
			$err = $this->db->error();
			if ($err['message']) {
				$this->db->trans_rollback();
				$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$err['message'].'</div>');
			}else{
				$this->db->trans_commit();
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data berhasil disimpan</div>');
			}
		}else{
			$this->session->set_flashdata('message',validation_errors('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>','</div>'));
		}
		redirect('receiving');

	}

	public function insert_recdet($data)
	{
		$this->load->model('m_receiving_detail');
		foreach ($data['div_detail'] as $x => $value) {
			if (empty($value['item_id'])) {
				continue;
			}
			foreach ($this->m_receiving_detail->rules() as $r => $v) {
				$detail[$x][$r] = isset($value[$r])?$value[$r]:null;
			}
			$detail[$x]['rec_id'] 		= $data['rec_id'];
			$detail[$x]['expired_date'] = date('Y-m-d',strtotime($value['expired_date']));
			$detail[$x]['price_item'] 	= $value['price_pack']/$value['unit_per_pack'];
			$detail[$x]['qty_unit']		= $value['qty_pack']*$value['unit_per_pack'];
		}
		$this->db->insert_batch("receiving_detail",$detail);
	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_receiving->get_column();
		$data 	= $this->datatable->get_data($fields,$filter = array(),'m_receiving',$attr);
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
		$data = $this->db->where('rec_id',$id)->get("receiving")->row();

		echo json_encode($data);
	}
	
	public function get_item()
	{
		$term = $this->input->get('term');
		$this->load->model('m_ms_item');
		echo json_encode($this->m_ms_item->get_autocomplete($term));
	}

	public function delete_row($id)
	{
		$this->db->where('rec_id',$id)->delete("receiving");
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
			$this->db->where('rec_id',$value)->delete("receiving");
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
		$data['model'] = $this->m_receiving->rules();
		$this->load->view("receiving/form",$data);
	}

	public function show_multiRows()
	{
		$this->load->model("m_receiving_detail");
		$data = $this->m_receiving_detail->get_column_multiple();
		$colauto = ["item_id"=>"Nama Barang"];
		foreach ($data as $key => $value) {
			if (array_key_exists($value, $colauto)) {
				$row[] = [
					"id" => $value,
					"label" => $colauto[$value],
					"type" => 'autocomplete',
				];
			}else{
				$row[] = [
					"id" => $value,
					"label" => ucwords(str_replace('_', ' ', $value)),
					"type" => 'text',
				];
			}
		}

		echo json_encode($row);
	}
}
