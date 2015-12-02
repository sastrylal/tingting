<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once 'admin.php';

class Posts extends Admin {

    public $header_data = array();

    function __construct() {
        parent::__construct();
        $this->_admin_login_check();
    }

    public function index() {        
        $data = array();
        if (!empty($_GET['act']) && $_GET['act'] == "del" && !empty($_GET['post_id'])) {
            $this->admin->delPost($_GET['post_id']);
            redirect(base_url() . "admin/posts/");
        }
        if (!empty($_GET['act']) && $_GET['act'] == "status" && !empty($_GET['post_id']) && isset($_GET['sta'])) {
            $is_active = (!empty($_GET['sta']) && $_GET['sta'] == "1") ? "1" : "0";
            $this->admin->updatePost($_GET['post_id'], array("is_active" => $is_active));
            redirect(base_url() . "admin/posts/");
        }
        $search_data = array();
        if (!empty($this->_REQ['key'])) {
            $search_data['key'] = $this->_REQ['key'];
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 100;
        $this->pagenavi->base_url = '/admin/posts/?';
        $this->pagenavi->process($this->admin, 'searchPosts');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['posts'] = $this->pagenavi->items;
        $this->_template('posts/index', $data);
    }

    public function add() {
        $data = array();
        if (!empty($_POST['first_name'])) {
            $pdata = array();
            $pdata['first_name'] = !empty($_POST['first_name']) ? trim($_POST['first_name']) : "";
            $this->admin->addPost($pdata);
            redirect(base_url() . "admin/posts/");
        }
        $this->_template('posts/form', $data);
    }

    public function edit() {
        $data = array();
        if (!empty($_POST['post_id'])) {
            $pdata = array();
            $pdata['first_name'] = !empty($_POST['first_name']) ? trim($_POST['first_name']) : "";
            $this->admin->updatePost($pdata, $_POST['post_id']);
            redirect(base_url() . "admin/posts/");
        }
        $data['country'] = $this->admin->getPostById($this->_REQ['post_id']);
        $this->_template('posts/form', $data);
    }

}
