<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function create_input($name,$attr = array()){
	$label=$name;
	if (strpos($name,"=")) {
		list($name,$label) = explode("=", $name);
	}
	$txt = '<div class="form-group">
              <label for="'.$name.'">'.ucwords(str_replace('_', ' ', $label)).'</label>
              <input type="text" class="form-control" name="'.$name.'" id="'.$name.'" '._attributes_to_string($attr).'>
            </div>';
    return $txt;
}

function create_inputDate($name,$jsscript = array(),$attr = array()){
	$label=$name;
	if (strpos($name,"=")) {
		list($name,$label) = explode("=", $name);
	}
	$txt = '<div class="form-group">'.form_label(ucwords(str_replace('_', ' ', $label)),$name).'
              <div class="input-group date">
                  <div class="input-group-addon show_date_'.$name.'">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <div class="input-group-addon">
                    <i class="fa fa-close" onclick="$(\'#'.$name.'\').val(null)"></i>
                  </div>
                  <input type="text" class="form-control" name="'.$name.'" id="'.$name.'" '._attributes_to_string($attr).'>
                </div>
            </div>';
    $CI =& get_instance();
    $js = $CI->config->item('footerJS');
    $js .= "\n $('#".$name."').datepicker(".json_encode($jsscript).")";
    $js .= "\n $('.show_date_".$name."').click(()=>{
    			$('#".$name."').datepicker('show');
    		})\n";
    $CI->config->set_item('footerJS',$js);
    return $txt;
}

function create_inputDaterange($name,$jsscript = array(),$attr = array()){
	$label=$name;
	if (strpos($name,"=")) {
		list($name,$label) = explode("=", $name);
	}
	$txt = '<div class="form-group">'.form_label(ucwords(str_replace('_', ' ', $label)),$name).'
              <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" name="'.$name.'" id="'.$name.'" '._attributes_to_string($attr).'>
                </div>
            </div>';
    $CI =& get_instance();
    $js = $CI->config->item('footerJS');
    $js .= "\n$('#".$name."').daterangepicker(".json_encode($jsscript).")";
    $CI->config->set_item('footerJS',$js);
    return $txt;
}

function create_textarea($name,$attr = array()){
	$label=$name;
	if (strpos($name,"=")) {
		list($name,$label) = explode("=", $name);
	}
	$txt = '<div class="form-group">
              <label for="'.$name.'">'.ucwords(str_replace('_', ' ', $label)).'</label>
              <textarea class="form-control" name="'.$name.'" id="'.$name.'" '._attributes_to_string($attr).'></textarea>
            </div>';
    return $txt;
}

/*function create_table($name,$modelName,$attr = array(),$noaction = 'true')
{
	$txt = '<table name="'.$name.'" id="'.$name.'" '._attributes_to_string($attr).'>
				<thead>
					<tr>
					<th></th>
					<th>NO</th>';
	$CI =& get_instance();
	$CI->load->model($modelName,'modelku');
	$header = $CI->modelku->get_column();
	foreach ($header as $key => $value) {
		if (!is_array($value)) {
			$txt .= '<th>'.strtoupper(str_replace('_', ' ', $value)).'</th>'."\n";
		}else{
			$txt .= '<th '._attributes_to_string(isset($value['attr'])?$value['attr']:array()).'>'.strtoupper(isset($value['label'])?$value['label']:str_replace('_', ' ', $key)).'</th>'."\n";
		}
	}

	if ($noaction == 'false') {
		$txt .= '</tr>
				</thead>
					<tbody></tbody>
			</table>';
	}else{
		$txt .= '<th>#</th></tr>
				</thead>
					<tbody></tbody>
			</table>';
	}

	return $txt;

}*/

function create_table($name,$modelName,$attr = array())
{
	$txt = '<table name="'.$name.'" id="'.$name.'" '._attributes_to_string($attr).'>
				<thead>
					<tr>
					<th><input type="checkbox" name="select_all" value="1" id="checkAll"></th>
					<th>NO</th>';
	$CI =& get_instance();
	$CI->load->model($modelName,'modelku');
	$header = $CI->modelku->get_column();
	foreach ($header as $key => $value) {
		if (!is_array($value)) {
			$txt .= '<th>'.strtoupper(str_replace('_', ' ', $value)).'</th>'."\n";
		}else{
			$txt .= '<th '._attributes_to_string(isset($value['attr'])?$value['attr']:array()).'>'.strtoupper(isset($value['label'])?$value['label']:str_replace('_', ' ', $key)).'</th>'."\n";
		}
	}

	$txt .= '<th>#</th></tr>
				</thead>
					<tbody></tbody>
			</table>';

	return $txt;

}

function create_btnAction($act,$id="")
{
	$txt = "";
	foreach ($act as $key => $value) {
		if ($value == 'update') {
			$txt .= '<button onclick="set_val(\''.$id.'\')" class="btn btn-xs btn-info" title="Edit">
	                            <i class="fa fa-pencil"></i>
	                        </button>';
		}elseif ($value == 'delete') {
			$txt .='	<button href="javascript:void(0)" onclick="deleteRow(\''.$id.'\')" class="btn btn-xs  btn-danger" title="Delete">
								<i class="fa fa-trash-o"></i>
	                        </button>';
		}else{
			$txt .=' <button href="javascript:void(0)" onclick="'.$value['btn-act'].'" class="btn btn-xs '.$value['btn-class'].'" title="'.$key.'">
								<i class="'.$value['btn-icon'].'"></i>
	                        </button>';
		}
	}
	return $txt;
}

function create_tableData($attr = array())
{
	$txt = '<table name="'.$attr['name'].'" id="'.$attr['name'].'" class="table table-bordered"'.(isset($attr['ext'])?_attributes_to_string($attr['ext']):'').'>
				<thead>
					<tr>
					<th>NO</th>';
	$CI =& get_instance();
	$CI->load->model(key($attr['model']),'modelku');
	$header = $CI->modelku->{current($attr['model'])}();
	foreach ($header as $key => $value) {
		if (!is_array($value)) {
			$txt .= '<th>'.strtoupper(str_replace('_', ' ', $value)).'</th>'."\n";
		}else{
			$txt .= '<th '._attributes_to_string(isset($value['attr'])?$value['attr']:array()).'>'.strtoupper(isset($value['label'])?$value['label']:str_replace('_', ' ', $key)).'</th>'."\n";
		}
	}

	$txt .= '</tr>
				</thead>
					<tbody>';
	foreach ($attr['data'] as $key => $value) {
		$txt .= "<tr>
					<td>".($key+1)."</td>
			";
		foreach ($header as $key => $rs) {
			$txt .= "<td>".$value->{$rs}."</td>";
		}
		$txt .= "</tr>";
	}

	$txt .= '</tbody>
			</table>';

	return $txt;

}

function modal_open($id,$header,$attr = "")
{
	$txt = '<div class="modal fade" id="'.$id.'">
	        <div class="modal-dialog">
	          <div class="modal-content">
	            <div class="modal-header">
	            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true">×</span></button>
	                <h4 class="modal-title">'.$header.' </h4></div>
	            <div class="modal-body" id="modal-body">';
	return $txt;
}

function modal_close($footer = null) {
	$txt = '</div>
	            <div class="modal-footer">';
	if ($footer) {
		foreach ($footer as $key => $value) {
			$txt .= $value."\n";
		}
	}
	$txt .='</div>
	          </div>
	        </div>
	        </div>';
	return $txt;
}

function create_modal($modal)
{
	$txt = '<div class="modal fade" id="'.$modal['id'].'">
	        <div class="modal-dialog">
	          <div class="modal-content">
	            <div class="modal-header">'.$modal['header'].'</div>
	            <div class="modal-body" id="modal-body"></div>
	            <div class="modal-footer"></div>
	          </div>
	        </div>
	        </div>';
	$CI =& get_instance();
	$modalBody = $CI->load->view('biodata_ppat/form','',true);
	libxml_use_internal_errors(true);
	$doc = new DOMDocument(); 
	$doc->loadHTML($txt);
	//get the element you want to append to
	$descBox = $doc->getElementById('modal-body');
	//create the element to append to #element1
	// $appended = $doc->createElement($modalBody);
	//actually append the element
	$descBox->appendChild(htmlspecialchars($modalBody));
	// echo $doc->saveHTML();
	// $txt .= '<script>$("#'.$modal['id'].'").find(".modal-body").html(\''.$modalBody.'\')</script>';
	return $doc->saveHTML();
}

function create_select($data)
{
	$label=$data['attr']['name'];
	if (strpos($data['attr']['name'],"=")) {
		list($data['attr']['name'],$label) = explode("=", $data['attr']['name']);
	}
	$txt = '<div class="form-group">
              <label for="'.$data['attr']['name'].'">'.ucwords(str_replace('_', ' ', $label)).'</label>';
	$txt .= '<select '._attributes_to_string($data['attr']).'>';
	if (isset($data['model'])) {
		$CI =& get_instance();
		$model = key($data['model']);
		$CI->load->model($model);
		$txt .= "<option value=\"\">--</option>\n";
		if (is_array(current($data['model']))) {
			$dataSelect = $CI->$model->{($data['model'][$model][0])}($data['model'][$model][1]);
		}else{
			$dataSelect = $CI->$model->{current($data['model'])}();
		}
		 foreach ($dataSelect as $key => $value) {
	        $txt .= "<option value =\"".$value->{$data["model"]['column'][0]}."\">".$value->{$data["model"]['column'][1]}."</option>\n";
	    }
	}elseif (isset($data['option'])) {
		foreach ($data['option'] as $key => $value) {
			if (is_array($value)) {
				$txt .="<option value=\"".$value['id']."\">".$value['text']."</option>\n";
			}else{
				$txt .= "<option>".$value."</option>\n";
			}
		}
	}
    $txt .= "</select>\n</div>";
	return $txt;
}

function create_switchbutton($name,$data = array())
{
	$txt = '<div class="form-group">
              <label for="'.$name.'">'.ucwords(str_replace('_', ' ', $name)).'</label><br>'.
              form_checkbox($name).
              '</div>';
	$CI  =& get_instance();
    $js  = $CI->config->item('footerJS');
    $js .= "\n$('#".$name."').bootstrapSwitch(".(isset($data)?array_to_json($data):null).")";
    $CI->config->set_item('footerJS',$js);
    return $txt;
}

function array_to_json($data)
{
	$var = json_encode($data);
    preg_match_all('/\"function.*?\"/', $var, $matches);
    foreach ($matches[0] as $key => $value) {
        $newval = str_replace(array('\n', '\r','\t','\/'), array(PHP_EOL,"\t",''), trim($value, '"'));
        $var = str_replace($value, $newval, $var);
    }
    return $var;
}

function create_select2($data)
{
	$txt = create_select($data);
	if (strpos($data['attr']['name'],"=")) {
		list($data['attr']['name'],$label) = explode("=", $data['attr']['name']);
	}
	$CI =& get_instance();
    $js = $CI->config->item('footerJS');
    $js .= "\n$('#".$data['attr']['name']."').select2(".json_encode((isset($data['select2'])?$data['select2']:[])).")";
    $CI->config->set_item('footerJS',$js);
    return $txt;
}

function create_inputMask($name,$jsscript = array(),$attr=array())
{
	$txt = create_input($name,$attr);
	if (strpos($name,"=")) {
		list($name,$label) = explode("=", $name);
	}
	$CI =& get_instance();
    $js = $CI->config->item('footerJS');
    // $js .= "\n$('#".$name."').inputmask(\"".$jsscript[0].'",'.json_encode(isset($jsscript[1])?$jsscript[1]:[]).")";
    if (is_array($jsscript)) {
    	$js .= "\n$('#".$name."').inputmask(\"".$jsscript[0].'",'.json_encode($jsscript[1]).")";
    }else{
    	$js .= "\n$('#".$name."').inputmask(\"".$jsscript."\")";
    }
    $CI->config->set_item('footerJS',$js);
    return $txt;
}

function create_inputFile($name,$jsscript = array(),$attr=array())
{
	$txt = '<div class="form-group">
	            <div class="file-loading">
	                <input type="file" name="'.$name.'" id="'.$name.'" data-upload-url="#">
	            </div>
	            <div id="errorBlock" class="help-block"></div>
	        </div>';
	$CI =& get_instance();
    $js = $CI->config->item('footerJS');
    if (is_array($jsscript)) {
    	$js .= "\n
    		$(document).ready(function() {
    			$('#".$name."').fileinput(\"".json_encode($jsscript).");
    		});";
    }else{
    	$js .= "\n$('#".$name."').fileinput()";
    }
    $CI->config->set_item('footerJS',$js);
    return $txt;
}

function label_status($condition)
{
	return "<span class=\"label ".$condition['class']."\">".$condition['text']."</span>";
	/*if ($st == 't') {
		$txt = "<span class=\"label label-primary\">Aktif</span>";
	}else{
		$txt = "<span class=\"label label-danger\">Non Aktif</span>";
	}*/
	// return $txt;
}