<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once 'admin.php';

class Countries extends Admin {

    public $header_data = array();

    function __construct() {
        parent::__construct();
        $this->_admin_login_check();
    }

    public function index() {
        $data = array();
        if (!empty($_GET['act']) && $_GET['act'] == "del" && !empty($_GET['country_id'])) {
            $this->admin->delCountry($_GET['country_id']);
            redirect(base_url() . "admin/countries/");
        }
        if (!empty($_GET['act']) && $_GET['act'] == "status" && !empty($_GET['country_id']) && isset($_GET['sta'])) {
            $is_active = (!empty($_GET['sta']) && $_GET['sta'] == "1") ? "1" : "0";
            $this->admin->updateCountry(array("is_active" => $is_active), $_GET['country_id']);
            redirect(base_url() . "admin/countries/");
        }
        $search_data = array();
        if (!empty($this->_REQ['name'])) {
            $search_data['name'] = $this->_REQ['name'];
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 100;
        $this->pagenavi->base_url = '/admin/countries/?';
        $this->pagenavi->process($this->admin, 'searchCountries');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['countries'] = $this->pagenavi->items;
        $this->_template('countries/index', $data);
    }

    public function add() {
        $data = array();
        if (!empty($_POST['country_name'])) {
            $pdata = array();            
            $pdata['country_code'] = !empty($_POST['country_code']) ? trim($_POST['country_code']) : "";
            $pdata['country_name'] = !empty($_POST['country_name']) ? trim($_POST['country_name']) : "";
            $this->admin->addCountry($pdata);
            redirect(base_url() . "admin/countries/");
        }        
        $this->_template('countries/form', $data);
    }

    public function edit() {
        $data = array();
        if (!empty($_POST['country_id'])) {
            $pdata = array();
            $pdata['country_code'] = !empty($_POST['country_code']) ? trim($_POST['country_code']) : "";
            $pdata['country_name'] = !empty($_POST['country_name']) ? trim($_POST['country_name']) : "";
            $this->admin->updateCountry($pdata, $_POST['country_id']);
            redirect(base_url() . "admin/countries/");
        }
        $data['country'] = $this->admin->getCountryById($this->_REQ['country_id']);
        $this->_template('countries/form', $data);
    }

}
