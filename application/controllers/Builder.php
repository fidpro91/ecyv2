<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Builder extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
	}
	public function index()
	{
		$data['data'] = $this->m_builder->get_allTable();
		$data['menu'] = "";
		$getMenu = $this->m_builder->get_menu(0);
		$menu = [];
		foreach ($getMenu as $key => $value) {
			$menu[] = [
						'text' => $value->menu_name,
						'id' => $value->menu_id,
						'childs' => $this->m_builder->get_menu_child($value->menu_id)
					];
		} 
		$data['menu'] = $menu;
		
		$this->theme('builder/index',$data);
	}

	public function create_mvc()
	{
		$tableName = $this->input->post('list_table');
		$data = $this->m_builder->get_fieldTable($tableName);
		if ($this->input->post('c_controller')) {
			$this->_createController($tableName,$data);
		}
		if ($this->input->post('c_model')) {
			$this->_createModel($tableName,$data);
		}
		if ($this->input->post('c_view')) {
			$this->_createView($tableName,$data);
		}

		$menu = [
					'menu_name' => $this->input->post('menu_name'),
					'menu_code' => $this->input->post('menu_code'),
					'menu_icon' => $this->input->post('menu_icon'),
					'menu_url' 	=> $this->input->post('menu_url'),
					'menu_status' 	=> 't',
					'menu_parent_id' 	=> ($this->input->post('menu_parent_id')?$this->input->post('menu_parent_id'):0),
				];
		$this->m_builder->create_menu($menu);
	}

	public function get_menu()
	{
		$getMenu = $this->m_builder->get_menu(0);
		$data = [];
		foreach ($getMenu as $key => $value) {
			$menu[] = [
						'text' => $value->menu_name,
						'id' => $value->menu_id,
						'childs' => $this->m_builder->get_menu_child($value->menu_id)
					];
			// $menu[]['id'] = $value->menu_id;
			/*$childs = $this->m_builder->get_menu_child($value->menu_id);
			if (count($childs)>0) {
				$menu[$key] = [
						'childs' => $childs
				];*/
				// array_merge_recursive($menu[$key],$tes[$key]);
			// }
		}
		$data= $menu;
		$tes ='<ul>';
		foreach ($menu as $key => $value) {
            if ($value['childs']) {
                $tes .= "<li value=\"".$value['id']."\" class=\"jstree-closed\">".$value['text']."</li>";
            }else{
                $tes .= "<li>".$value['text']."</li>";
            }
          }
        $tes .= '</ul>';

		echo $tes;
	}

	public function get_menu2()
	{
		
		$id = $this->input->get('id');
		$getMenu = $this->m_builder->get_menu($id);
		$data = [];	
		foreach ($getMenu as $i => $value) {
			$data[$i]['attr'] 		= $value;
			$data[$i]['data'] 		= $value->menu_code.'-'.$value->menu_name;
			$data[$i]['metadata'] 	= $value;
			$data[$i]['state'] 		= 'closed';
			if( !$this->m_builder->get_menu_child( $value->menu_id )  ){
				$data[$i]['state'] 		= 'disabled';
			}
			$i++;
		}
		echo json_encode($data);
	}
	public function _createController($tableName,$data)
	{
		$className = $tableName;
		if (strpos($tableName,'.') > 0) {
			$tb = explode('.', $tableName);
			$className = $tb[1];
		}
		$file = read_file(APPPATH."docs/mvc/controller.php");

		$file = str_replace('$classNameHeader', ucfirst($className), $file);
		$file = str_replace('$className', ($className), $file);
		$file = str_replace('$tableName', ($tableName), $file);
		foreach ($data as $key => $value) {
			if ($value->primary_key > 0) {
				$file = str_replace('$pkey',($value->name), $file);
			}
		}
		write_file(APPPATH.'controllers/'.ucfirst($className).'.php',$file,"wa+");

	}

	public function _createModel($tableName,$data)
	{
		$className = $tableName;
		if (strpos($tableName,'.') > 0) {
			$tb = explode('.', $tableName);
			$className = $tb[1];
		}
		$file = read_file(APPPATH."docs/mvc/model.php");
		$column = "[\n";
		$rule = "";
		foreach ($data as $key => $value) {
			$column .= "\t\t\t\t\"$value->name\",\n";
			if ($key>0 and $value->name_key != 'PRI') {
				$rule .= "\t\t\t\t\t";
			}
			if ($value->name_key == 'PRIMARY KEY' || $value->name_key == 'PRI') {
				$pkey = $value->name;
			}
			if ($value->extra == '' and ($value->name_key != 'PRI' || $value->name_key != 'PRIMARY KEY')) {
				$rule .= '"'.$value->name.'" => "trim|';
				if ($value->type == 'int' || $value->type == 'bigint' || $value->type == 'integer' || $value->type == 'smallint') {
					$rule .= 'integer|';
				}elseif ($value->type == 'float' || $value->type == 'double precision') {
					$rule .= 'numeric|';
				}
				if ($value->is_null == 'NO') {
					$rule .= 'required|';
				}
				/*if ($value->name_key == 'UNI' || $value->name_key == 'UNIQUE') {
					$rule .= 'is_unique['.$tableName.'.'.$value->name.']|';
				}*/
				$rule = rtrim($rule,'|')."\",\n";
			}
		}
		$column = rtrim($column,",\n")."]";
		$file = str_replace('$className',($className), $file);
		$file = str_replace('$tableName',($tableName), $file);
		$file = str_replace('$pkey',($pkey), $file);
		$file = str_replace('$kolom',($column), $file);
		$file = str_replace('$ruleData',($rule), $file);
		write_file(APPPATH.'models/M_'.($className).'.php',$file,"wa+");

	}

	public function _createView($tableName,$data)
	{
		$className = $tableName;
		if (strpos($tableName,'.') > 0) {
			$tb = explode('.', $tableName);
			$className = $tb[1];
		}
		$txt = read_file(APPPATH."docs/mvc/views/form.html");
		$txt2 = read_file(APPPATH."docs/mvc/views/index.html");
		$form = "\t\t\t".'<?=form_open("'.$className.'/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_'.$tableName.'"],$model)?>'."\n";
		$hd=[];
		foreach ($data as $key => $value) {
			if ($value->primary_key > 0) {
				$form .= "\t\t".'<?=form_hidden("'.$value->name.'")?>'."\n";
			}else{
				$form .= "\t\t\t".'<?=create_input("'.$value->name.'")?>'."\n";
			}
			$hd[] = "'".strtoupper(str_replace('_', ' ', $value->name))."'";
		}
		$hd = implode(",\n",$hd);
		$headerTable = '<?=create_table("tb_'.$className.'","M_'.$className.'",["class"=>"table table-bordered" ,"style" => "width:100% !important;"])?>';
		$form .= '<?=form_close()?>';
		$txt = str_replace('$form',($form), $txt);
		$txt = str_replace('$className',($className), $txt);
		$txt = str_replace('$tableName',($tableName), $txt);
		$txt2 = str_replace('$judul',ucwords(str_replace('_', ' ', $className)), $txt2);
		$txt2 = str_replace('$className',$className, $txt2);
		$txt2 = str_replace('$tableName',$tableName, $txt2);
		$txt2 = str_replace('$dataTable',$headerTable, $txt2);
		$patch = APPPATH."views/".$className; 
		// delete_files($patch,TRUE);
		array_map('unlink', array_filter( 
            (array) array_merge(glob($patch."/*"))));
        rmdir($patch); 
		mkdir($patch);
		write_file($patch.'/form.php',$txt);
		write_file($patch.'/index.php',$txt2);

	}

	public function err_404()
	{
		$this->theme('errors/error_404');
	}
}
