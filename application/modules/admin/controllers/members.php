<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once 'admin.php';

class Members extends Admin {

    public $header_data = array();

    function __construct() {
        parent::__construct();
        $this->_admin_login_check();
    }

    public function index() {
        //$server = new SoapServer();
        $data = array();
        if (!empty($_GET['act']) && $_GET['act'] == "del" && !empty($_GET['member_id'])) {
            $this->admin->delMember($_GET['member_id']);
            redirect(base_url() . "admin/members/");
        }
        if (!empty($_GET['act']) && $_GET['act'] == "status" && !empty($_GET['member_id']) && isset($_GET['sta'])) {
            $is_active = (!empty($_GET['sta']) && $_GET['sta'] == "1") ? "1" : "0";
            $this->admin->updateMember($_GET['member_id'], array("is_active" => $is_active));
            redirect(base_url() . "admin/members/");
        }
        $search_data = array();
        if (!empty($this->_REQ['key'])) {
            $search_data['key'] = $this->_REQ['key'];
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 100;
        $this->pagenavi->base_url = '/admin/members/?';
        $this->pagenavi->process($this->admin, 'searchMembers');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['members'] = $this->pagenavi->items;
        $this->_template('members/index', $data);
    }

    public function add() {
        $data = array();
        if (!empty($_POST['first_name'])) {
            $pdata = array();
            $pdata['first_name'] = !empty($_POST['first_name']) ? trim($_POST['first_name']) : "";
            $this->admin->addMember($pdata);
            redirect(base_url() . "admin/members/");
        }
        $this->_template('members/form', $data);
    }

    public function edit() {
        $data = array();
        if (!empty($_POST['member_id'])) {
            $pdata = array();
            $pdata['first_name'] = !empty($_POST['first_name']) ? trim($_POST['first_name']) : "";
            $this->admin->updateMember($pdata, $_POST['member_id']);
            redirect(base_url() . "admin/members/");
        }
        $data['country'] = $this->admin->getMemberById($this->_REQ['member_id']);
        $this->_template('members/form', $data);
    }

}
