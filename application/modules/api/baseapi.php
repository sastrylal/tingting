<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseApi extends CI_Controller {

    public $header_data = array();

    function __construct() {
        parent::__construct();
        $this->load->model("AdminModel", "admin", TRUE);
        $this->_REQ = $_POST + $_GET;
        $this->load->helper('common');
    }

    public function index() {
        
    }

    public function _out($data = []) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function sendEmail($view, $data = []) {
        //try {
        if (empty($data['from'])) {
            $data['from'] = "admin@tingtingapp.com";
        }
        include_once(rtrim(APPPATH, "/") . "/third_party/phpmailer/class.phpmailer.php");
        $body = $this->load->view($view, $data, true);
        $mail = new PHPMailer(true);
        //$mail->IsSMTP();
        //$mail->SMTPAuth = true;
        //$mail->Host = "mail.tingtingapp.com";
        //$mail->Port = 26;
        //$mail->Username = "admin@tingtingapp.com";
        //$mail->Password = "Dev@123";
        if (!empty($data['from']) && !empty($data['from_name'])) {
            $mail->SetFrom($data['from'], $data['from_name']);
        } else if (!empty($data['from'])) {
            $mail->SetFrom($data['from']);
        }
        if (!empty($data['to']) && !empty($data['to_name'])) {
            $mail->AddAddress($data['to']);
        } else if (!empty($data['to'])) {
            $mail->AddAddress($data['to']);
        }
        $mail->Subject = !empty($data['subject']) ? $data['subject'] : "";
        $mail->isHTML(true);
        $mail->MsgHTML($body);
        $mail->Body = $body;
        $mail->Send();
        //} catch (phpmailerException $e) {
        //    echo $e->errorMessage(); //Pretty error messages from PHPMailer
        //} catch (Exception $e) {
        //    echo $e->getMessage(); //Boring error messages from anything else!
        //}
    }

    /* public function _remap($method, $params = array()) {
      $data = array();
      $this->header_data['page_name'] = $method;
      $method = str_replace("-", "_", $method);
      $this->method = $method;
      if (method_exists($this, $method)) {
      return call_user_func_array(array($this, $method), $params);
      } else {
      //redirect(base_url());
      }
      } */
}
