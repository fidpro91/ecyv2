<?php
class siswa
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
        // $this->CI->config->set_item('my_library',$this->combine);
        return $this;
    }

    public function lib_datepicker()
    {
        $this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">'."\n";
        $this->combine .= '<script src="'.$this->folder_js.'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>'."\n";
        // $this->CI->config->set_item('my_library',$this->combine);
        return $this;
    }

    public function __invoke()
    {
       
       $this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'dist/css/AdminLTE.min.css">'."\n";
       $this->CI->config->set_item('my_library',$this->combine);
       return "Nama saya adalah ".htmlspecialchars($this->CI->config->item('my_library'));
    }
}

$budi = new siswa();
$CI =& get_instance();
$budi->lib_datepicker();
echo htmlspecialchars($CI->config->item('my_library'));
?>