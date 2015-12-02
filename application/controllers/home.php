<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    public $header_data = array();

    function __construct() {
        parent::__construct();
        $this->load->model("AdminModel", "admin", TRUE);
    }

    public function index() {
        $data = array();
        $this->_template("home", $data);
    }

    public function signup() {
        $data = array();
        if (!empty($_POST['email'])) {
            $pdata = array();
            $pdata['name'] = !empty($_POST['name']) ? $_POST['name'] : "";
            $pdata['email'] = !empty($_POST['email']) ? $_POST['email'] : "";
            $pdata['pwd'] = "Admin@123";
            $pdata['gender'] = !empty($_POST['gender']) ? $_POST['gender'] : "";
            $pdata['is_active'] = "1";
            $email_exist = $this->admin->checkMemberEmail($pdata['email']);
            if ($email_exist) {
                $_SESSION['error'] = "Already registed with this Email address";
            } else {
                $this->admin->addMember($pdata);
                $_SESSION['message'] = "Your Signup has been completed successfully.";
                redirect(base_url());
            }
        }
        $this->_template("home/signup", $data);
    }

    public function logout() {
        $_SESSION = array();
        redirect(base_url() . "login/");
    }

}
