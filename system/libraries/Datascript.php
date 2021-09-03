<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class CI_Datascript 
{
	public $folder_js,$folder_css,$CI,$js,$css,$combine;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->config->item('my_library');
		$this->folder_css = base_url()."assets/";
		$this->folder_js = base_url()."assets/";
		$this->default_library();
	}

	public function default_library()
	{
		$this->css .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/bootstrap/dist/css/bootstrap.min.css">'."\n";
		$this->css .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/font-awesome/css/font-awesome.min.css">'."\n";
		$this->css .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/Ionicons/css/ionicons.min.css">'."\n";
		$this->css .= '<link rel="stylesheet" href="'.$this->folder_css.'dist/css/AdminLTE.min.css">'."\n";
		$this->css .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/jquery-ui/themes/base/all.css">'."\n";
		$this->css .= '<link rel="stylesheet" href="'.$this->folder_css.'dist/css/skins/_all-skins.min.css">'."\n";
		$this->css .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">'."\n";

		$this->js .= '<script src="'.$this->folder_js.'bower_components/jquery/dist/jquery.min.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'bower_components/bootstrap/dist/js/bootstrap.min.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'bower_components/fastclick/lib/fastclick.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'dist/js/adminlte.min.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'dist/js/demo.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'plugins/breadcumb/breadcumb.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'bower_components/jquery-ui/jquery-ui.min.js"></script>'."\n";
		/*$this->js .= '<script src="'.$this->folder_js.'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>'."\n";*/
		$this->js .= '<script src="'.$this->folder_js.'bower_components/datatables.net/js/jquery.dataTables.min.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'plugins/jquery-validation/jquery.validate.min.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'plugins/jquery-validation/additional-methods.min.js"></script>'."\n";
		$this->combine = $this->css."\n\n\n".$this->js;
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_datepicker()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_inputmulti()
	{
		$this->combine .= '<script src="'.$this->folder_js.'plugins/input-multi-row.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_switchbutton()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_daterange()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/bootstrap-daterangepicker/daterangepicker.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/moment/min/moment.min.js"></script>'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_inputMask()
	{
		// $this->combine .= '<script src="'.$this->folder_js.'plugins/input-mask/dist/inputmask.js"></script>'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'plugins/input-mask/dist/jquery.inputmask.js"></script>'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'plugins/input-mask/dist/bindings/inputmask.binding.js"></script>'."\n";
		$this->combine .= '<script>
		Inputmask.extendAliases({
			  "IDR": {
			    alias: "decimal",
			    allowMinus: false,
				radixPoint: ".",
				autoGroup: true,
				groupSeparator: ",",
				groupSize: 3,
				autoUnmask: true,
				removeMaskOnSubmit:true
			  }
			});
		</script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_select2()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'plugins/select2/dist/css/select2.min.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'plugins/select2/dist/js/select2.full.min.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_morrischart()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/morris.js/morris.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/raphael/raphael.min.js"></script>'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/morris.js/morris.min.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_daterangePicker()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/bootstrap-daterangepicker/daterangepicker.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_customUpload()
	{
		$this->combine .= '
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
		<link rel="stylesheet" href="'.$this->folder_css.'plugins/bootstrap-fileinput/css/fileinput.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'plugins/bootstrap-fileinput/js/fileinput.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_jstree()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'plugins/jstree_ver1/themes/classic/style.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'plugins/jstree_ver1/jquery.jstree.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;

	}

	public function lib_datatableExt()
	{
		$this->combine .= '<script src="'.$this->folder_js.'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
		<script src="'.$this->folder_js.'plugins/datatables-buttons/js/buttons.print.min.js"></script>
		<script src="'.$this->folder_js.'plugins/jszip/jszip.min.js"></script>
		<script src="'.$this->folder_js.'plugins/pdfmake/pdfmake.min.js"></script>
		<script src="'.$this->folder_js.'plugins/pdfmake/vfs_fonts.js"></script>
		<script src="'.$this->folder_js.'plugins/datatables-buttons/js/buttons.html5.min.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;

	}
	/*public function __toString()
	  {
	      return $this->CI->config->item('my_library');
	  }*/

}