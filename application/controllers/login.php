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
            $member = $this->admin->memberLogin($_POST['email'], $_POST['pwd']);            
            $_SESSION = array();
            if (!empty($member['email'])) {
                $_SESSION['NAME'] = $member['name'];
                $_SESSION['EMAIL'] = $member['email'];
                $_SESSION['MEMBER_ID'] = $member['member_id'];
                $_SESSION['auth_token'] = $member['auth_token'];
                redirect(base_url() . "member/");
            } else {
                $_SESSION['error'] = "Invalid email/password";
            }
        }
        $data = array();
        $this->_template('login', $data);
    }

}
