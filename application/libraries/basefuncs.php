<?php
defined('BASEPATH') or exit('No direct script access allowed');
//$baseurl = base_url();
//$ci=& get_instance();
//$ci->load->model('Common_model', 'common');
class basefuncs
{

    public function includelib($baseurl, $libmode = '', $libname = '')
    {
        $str = '';
        if ($libname) {
            switch ($libmode) {
                case "css":
                    $str .= '<link rel="stylesheet" href="' . $baseurl . 'assets/css/' . $libname . '.css">';
                    break;
                case "js":
                    $str .= '<script src="' . $baseurl . 'assets/js/' . $libname . '.js"></script>';
                    break;
                default:
                    $str .= '';
            }
        }
        return $str;
    }
    
}
