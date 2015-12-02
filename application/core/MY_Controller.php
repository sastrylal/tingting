<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $header_data = array();

    function __construct() {
        parent::__construct();
        $this->_REQ = $_POST + $_GET;
        $this->load->helper('common');
    }

    public function _admin_login_check() {
        if (!isset($_SESSION))
            session_start();
        if (!empty($_SESSION['ADMIN_ID'])) {
            
        } else {
            redirect(base_url() . "admin/login/");
        }
    }

    public function _user_login_check() {
        if (!isset($_SESSION))
            session_start();
        if (!empty($_SESSION['MEMBER_ID'])) {
            
        } else {
            redirect(base_url() . "login/");
        }
    }

    function _do_upload($field, $prefex, $folder = '/data/', $timestap = true) {
        //$config['file_name'] = $prefex.date("YmdHis");
        $config['file_name'] = $prefex;
        if ($timestap) {
            $config['file_name'] = $config['file_name'] . date("YmdHis");
        }
        if (empty($config['file_name'])) {
            $config['file_name'] = $prefex . date("YmdHis");
        }
        if (!file_exists(DOC_ROOT_PATH . $folder)) {
            mkdir(DOC_ROOT_PATH . $folder, 0755, true);
        }
        $config['upload_path'] = DOC_ROOT_PATH . $folder;
        $config['allowed_types'] = 'gif|jpg|jepg|png';
        $config['overwrite'] = TRUE;
        if (!file_exists($config['upload_path']) || !is_dir($config['upload_path'])) {
            mkdir($config['upload_path']);
        }
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($field)) {
            return $this->upload->display_errors();
        } else {
            return $this->upload->data();
        }
    }

    public function _remap($method, $params = array()) {
        $data = array();
        $this->header_data['page_name'] = $method;
        $method = str_replace("-", "_", $method);
        $this->method = $method;
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            //redirect(base_url());
        }
    }

    public function _template($page_name = 'index', $data = array()) {
        $this->load->view('header', $this->header_data);
        $this->load->view($page_name, $data);
        $this->load->view('footer');
    }

    public function _iframe($page_name = 'index', $data = array()) {
        $this->load->view('iframe_header', $this->header_data);
        $this->load->view($page_name, $data);
        $this->load->view('iframe_footer');
    }

}
