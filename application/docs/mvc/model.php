<?php

class M_$className extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",$pkey as id_key  from $tableName where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",$pkey as id_key  from $tableName where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = $kolom;
		return $col;
	}

	public function rules()
	{
		$data = [
					$ruleData
				];
		return $data;
	}

	public function validation()
	{
		foreach ($this->rules() as $key => $value) {
			$this->form_validation->set_rules($key,$key,$value);
		}

		return $this->form_validation->run();
	}

	public function get_$tableName($where)
	{
		return $this->db->get_where("$tableName",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("$tableName",$where)->row();
	}
}