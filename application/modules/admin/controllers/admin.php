<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MY_Controller {

    public $header_data = array();

    function __construct() {
        parent::__construct();
        $this->_admin_login_check();
        $this->load->model("AdminModel", "admin", TRUE);
    }

    public function index() {
        $data = array();
        $this->_template('admin/dashboard', $data);
    }

    public function dashboard() {
        $data = array();
        $this->_template('admin/dashboard', $data);
    }

    public function profile() {
        $data = array();        
        if (!empty($_POST['frm_profile'])) {
            $pdata = array();
            $pdata['name'] = !empty($_POST['name']) ? trim($_POST['name']) : "";
            $pdata['email'] = !empty($_POST['email']) ? trim($_POST['email']) : "";
            $this->admin->updateAdmin($pdata, $_SESSION['ADMIN_ID']);
            $_SESSION['message'] = "Your Profile has been updated successfully.";
            redirect(base_url() . "admin/profile/");
        }
        if (!empty($_POST['frm_pwd'])) {
            $pdata = array();
            $pdata['pwd'] = !empty($_POST['pwd']) ? trim($_POST['pwd']) : "";
            $this->admin->updateAdmin($pdata, $_SESSION['ADMIN_ID']);
            $_SESSION['message'] = "Your Password has been updated successfully.";
            redirect(base_url() . "admin/profile/");
        }
        $data['admin'] = $this->admin->getAdminById($_SESSION['ADMIN_ID']);
        $this->_template('profile', $data);
    }
    
    public function doc() {
         $this->_template('doc');
    }

    public function logout() {
        $_SESSION = [];
        redirect(base_url() . "admin/login/");
    }

}
