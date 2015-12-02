<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member extends MY_Controller {

    public $header_data = array();

    function __construct() {
        parent::__construct();
        $this->load->model("AdminModel", "admin", TRUE);
    }

    public function index() {
        $data = array();
        $this->_template("member/home", $data);
    }

    public function create_post() {
        $data = array();
        $this->_template("member/create_post", $data);
    }

    public function myposts() {
        $data = array();
        if (!empty($_GET['act']) && $_GET['act'] == "del" && !empty($_GET['post_id'])) {
            $this->admin->delPost($_GET['post_id']);
            redirect(base_url() . "member/myposts/");
        }
        if (!empty($_GET['act']) && $_GET['act'] == "status" && !empty($_GET['post_id']) && isset($_GET['sta'])) {
            $is_active = (!empty($_GET['sta']) && $_GET['sta'] == "1") ? "1" : "0";
            $this->admin->updatePost($_GET['post_id'], array("is_active" => $is_active));
            redirect(base_url() . "member/myposts/");
        }
        $search_data = array();
        if (!empty($this->_REQ['key'])) {
            $search_data['key'] = $this->_REQ['key'];
        }
        $search_data['member_id'] = $_SESSION['MEMBER_ID'];
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 100;
        $this->pagenavi->base_url = '/member/myposts/?';
        $this->pagenavi->process($this->admin, 'searchPosts');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['posts'] = $this->pagenavi->items;
        $this->_template('member/myposts', $data);
    }

    public function look_out() {
        $data = array();
        $search_data = array();
        if (!empty($this->_REQ['key'])) {
            $search_data['key'] = $this->_REQ['key'];
        }
        $search_data['member_id'] = $_SESSION['MEMBER_ID'];
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 100;
        $this->pagenavi->base_url = '/member/look_out/?';
        $this->pagenavi->process($this->admin, 'searchMemberPosts');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['posts'] = $this->pagenavi->items;
        $this->_template('member/lookout', $data);
    }

    public function logout() {
        $_SESSION = array();
        redirect(base_url() . "login/");
    }

}
