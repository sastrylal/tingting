<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MY_Controller {

    public $header_data = array();

    function __construct() {
        parent::__construct();
        $this->load->model("AdminModel", "admin", TRUE);
    }

    public function index() {
        if (!empty($_POST['email'])) {
            $admin = $this->admin->adminLogin($_POST['email'], $_POST['pwd']);
            $_SESSION = array();
            if (!empty($admin['email'])) {
                $_SESSION['NAME'] = $admin['name'];
                $_SESSION['EMAIL'] = $admin['email'];
                $_SESSION['ADMIN_ID'] = $admin['admin_id'];
                redirect(base_url() . "admin/");
            }
        }
        $data = array();
        $this->load->view('login', $data);
    }

}
