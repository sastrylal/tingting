<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once dirname(dirname(__FILE__)) . '/baseapi.php';

/*
 * Ting Ting API
 * 
 * @author L B Sastry
 * @api tingting
 * @version 1.0
 */

class Api extends BaseApi {

    private $request = [];

    function __construct() {
        parent::__construct();
        $this->request = file_get_contents('php://input');
        if (!empty($this->request)) {
            $this->request = json_decode($this->request, true);
        }
        $this->load->library('form_validation');
    }

    /*
     * This is welcome service
     */

    public function index() {
        $data = array();
        $data['message'] = "Welcome";
        $this->_out($data);
    }

    public function login() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['errors'] = [];
        $response['data'] = [];
        if (!empty($this->request)) {
            $_POST = $this->request;
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('pwd', 'Password', 'required');
            if ($this->form_validation->run() == true) {
                $member = $this->admin->memberLogin($_POST['email'], $_POST['pwd']);
                if (!empty($member['member_id']) && $member['is_active'] == "1") {
                    $response['response'] = true;
                    $response['status'] = "success";
                    $response['data']['auth_token'] = $member['auth_token'];
                    $response['data']['member_id'] = $member['member_id'];
                } else if (!empty($member['member_id'])) {
                    $response['data']['auth_token'] = $member['auth_token'];
                    $response['message'] = "Your account is not activated.";
                    $response['errors']['email'] = "Your account is not activated.";
                } else {
                    $response['message'] = "Invalid Email/Mobile or Password.";
                    $response['errors']['email'] = "Invalid Email/Mobile or Password.";
                }
            } else {
                $response['errors'] = $this->form_validation->error_array();
            }
        }
        $this->_out($response);
    }

    public function signup() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['errors'] = [];
        $response['data'] = [];
        if (!empty($this->request)) {
            $pdata = array();
            $_POST = $this->request;
            $this->form_validation->set_rules('name', 'Name', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|email|is_unique[tbl_members.email]');
            //$this->form_validation->set_rules('pwd', 'Password', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim');
            $this->form_validation->set_rules('birth_date', 'Date of Birth', 'trim');
            $this->form_validation->set_rules('zip_code', 'Zip', 'trim');
            $this->form_validation->set_rules('country_id', 'Country', 'trim');
            if ($this->form_validation->run() == true && (!empty($_POST['email']) || !empty($_POST['mobile']))) {
                $pdata = array();
                $pdata['name'] = !empty($_POST['name']) ? $_POST['name'] : "";
                $pdata['gender'] = !empty($_POST['gender']) ? ucfirst(strtolower($_POST['gender'])) : "";
                $pdata['email'] = !empty($_POST['email']) ? $_POST['email'] : "";
                $pdata['pwd'] = !empty($_POST['pwd']) ? $_POST['pwd'] : generatePassword();
                $pdata['mobile'] = !empty($_POST['mobile']) ? $_POST['mobile'] : "";
                $pdata['birth_date'] = !empty($_POST['birth_date']) ? $_POST['birth_date'] : "";
                $pdata['location'] = !empty($_POST['location']) ? $_POST['location'] : "";
                $pdata['zip_code'] = !empty($_POST['zip_code']) ? $_POST['zip_code'] : "";
                $pdata['country_id'] = !empty($_POST['country_id']) ? strtoupper($_POST['country_id']) : "";
                $pdata['disability'] = !empty($_POST['disability']) ? $_POST['disability'] : "";
                $pdata['tag_line'] = !empty($_POST['tag_line']) ? $_POST['tag_line'] : "";
                $pdata['otp_code'] = generateOTP();
                $member_id = $this->admin->addMember($pdata);

                $auth_token = md5($member_id . "TING" . date("YmdHis"));
                $this->admin->updateMember($member_id, ['auth_token' => $auth_token]);

                $pdata['to'] = $pdata['email'];
                $pdata['subject'] = "New Registration";
                $this->sendEmail("email/signup", $pdata);
                $pdata['subject'] = "Ting Ting OTP";
                $this->sendEmail("email/otp", $pdata);

                $response['data']['member_id'] = $member_id;
                $response['data']['auth_token'] = $auth_token;
                $response['response'] = "true";
                $response['status'] = "success";
                $response['message'] = "Registration completed successfully. And OTP has been sent.";
            } else {
                $response['errors'] = $this->form_validation->error_array();
                if (!(!empty($_POST['email']) || !empty($_POST['mobile']))) {
                    $response['errors']['email'] = "Please enter al least one Email or Mobile.";
                }
            }
        }
        $this->_out($response);
    }

    public function otp_confirm() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        if (!empty($this->request)) {
            $member = $this->check_auth();
            if (!empty($member['otp_code']) && !empty($this->request['otp_code']) && $member['otp_code'] == $this->request['otp_code']) {
                $this->admin->updateMember($member['member_id'], ["is_active" => "1", "otp_code" => ""]);
                $response['response'] = "true";
                $response['status'] = "success";
                $response['message'] = ['Your Account has been Activated.'];
            } else {
                $response['errors']['otp_code'] = "Invalid OTP";
            }
        }
        $this->_out($response);
    }

    public function otp_resent() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['errors'] = [];
        $response['data'] = [];
        if (!empty($this->request)) {
            $member = $this->check_auth();
            $otp_code = generateOTP();
            $this->admin->updateMember($member['member_id'], ["otp_code" => $otp_code]);
            $member['subject'] = "Ting Ting OTP";
            $member['to'] = $member['email'];
            $this->sendEmail("email/otp", $member);
            $response['response'] = "true";
            $response['status'] = "success";
            $response['message'] = "Your OTP has been sent.";
        }
        $this->_out($response);
    }

    public function profile() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['errors'] = [];
        $response['data'] = [];
        if (!empty($this->request)) {
            $member = $this->check_auth();
            $pdata = array();
            $_POST = $this->request;
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            //$this->form_validation->set_rules('email', 'Email', 'trim|required|email');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
            if ($this->form_validation->run() == true) {
                $pdata = array();
                if (!empty($_POST['name'])) {
                    $pdata['name'] = $_POST['name'];
                }
                if (!empty($_POST['mobile'])) {
                    $pdata['mobile'] = $_POST['mobile'];
                }
                if (!empty($_POST['birth_date'])) {
                    $pdata['birth_date'] = $_POST['birth_date'];
                }
                if (!empty($_POST['location'])) {
                    $pdata['location'] = $_POST['location'];
                }
                if (!empty($_POST['zip_code'])) {
                    $pdata['zip_code'] = $_POST['zip_code'];
                }
                if (!empty($_POST['country_id'])) {
                    $pdata['country_id'] = $_POST['country_id'];
                }
                if (!empty($_POST['disability'])) {
                    $pdata['disability'] = $_POST['disability'];
                }
                if (!empty($_POST['tag_line'])) {
                    $pdata['tag_line'] = $_POST['tag_line'];
                }
                $this->admin->updateMember($member['member_id'], $pdata);
                $response['data']['member_id'] = $member['member_id'];
                $response['data']['auth_token'] = $member['auth_token'];
                $response['response'] = "true";
                $response['status'] = "success";
                $response['message'] = "Your profile has been updated successfully.";
            } else {
                $response['errors'] = $this->form_validation->error_array();
            }
        }
        $this->_out($response);
    }

    public function profile_view() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['errors'] = [];
        $response['data'] = [];
        if (!empty($this->request)) {
            $member = $this->check_auth();
            $member = $this->admin->getMemberById($member['member_id']);
            $response['data']['member'] = $member;
            $response['data']['auth_token'] = $member['auth_token'];
            $response['response'] = "true";
            $response['status'] = "success";
        }
        $this->_out($response);
    }

    public function change_password() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        if (!empty($this->request)) {
            $member = $this->check_auth();
            $member = $this->dbapi->getMemberById($member['member_id']);
            if (!empty($this->request['newpwd']) && !empty($this->request['pwd']) && $member['pwd'] == $this->request['pwd']) {
                $this->admin->updateMember($member['member_id'], ["pwd" => $this->request['newpwd']]);
                $response['response'] = "true";
                $response['status'] = "success";
                $response['message'] = ['Your Account has been Activated.'];
            } else {
                if ($member['pwd'] != $this->request['pwd']) {
                    $response['errors']['pwd'] = "Worng Password.";
                }
                if (empty($this->request['newpwd'])) {
                    $response['errors']['newpwd'] = "New Password can't empty";
                }
            }
        }
        $this->_out($response);
    }

    public function reset_password() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        if (!empty($this->request)) {
            $member = $this->check_auth();
            $otp_code = generateOTP();
            $this->admin->updateMember($member['member_id'], ["otp_code" => $otp_code]);
            $member['subject'] = "Ting Ting Password Reset OTP";
            $member['to'] = $member['email'];
            $this->sendEmail("email/otp", $member);
        }
        $this->_out($response);
    }

    public function change_password_with_otp() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        if (!empty($this->request)) {
            $member = $this->check_auth();
            if (empty($this->request['newpwd'])) {
                $response['errors']['newpwd'] = "New Password can't empty";
            }
            if (!empty($member['otp_code']) && !empty($this->request['otp_code']) && $member['otp_code'] == $this->request['otp_code']) {
                $this->admin->updateMember($member['member_id'], ["pwd" => $this->request['newpwd']]);
                $response['response'] = "true";
                $response['status'] = "success";
                $response['message'] = ['Your Password has been updated.'];
            } else {
                $response['errors']['otp_code'] = "Invalid OTP";
            }
        }
        $this->_out($response);
    }

    public function rating() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        $member = $this->check_auth();
        if (!empty($this->request['member_id']) && !empty($this->request['rating'])) {
            $rating_to = $this->admin->getMemberById($this->request['member_id']);
            if (!empty($rating_to['member_id'])) {
                $this->admin->addMemberRating($member['member_id'], $this->request['member_id'], $this->request['rating']);
                $response['response'] = "true";
                $response['status'] = "success";
                $response['message'] = "Your raing has been updated.";
            }
        }
        $this->_out($response);
    }

    public function review() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        $member = $this->check_auth();
        if (!empty($this->request['member_id']) && !empty($this->request['review'])) {
            $review_to = $this->admin->getMemberById($this->request['member_id']);
            if (!empty($review_to['member_id'])) {
                $this->admin->addMemberReview($member['member_id'], $this->request['member_id'], $this->request['review']);
                $response['response'] = "true";
                $response['status'] = "success";
                $response['message'] = "Your Review has been updated.";
            }
        }
        $this->_out($response);
    }

    public function member_geo() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        $member = $this->check_auth();
        if (!empty($this->request)) {
            $is_online = !empty($this->request['is_online']) ? $this->request['is_online'] : "1";
            $this->admin->updateMemberGeo($member['member_id'], [
                "latitude" => $this->request['latitude'],
                "longitude" => $this->request['longitude'],
                "is_online" => $is_online
            ]);
            $response['response'] = "true";
            $response['status'] = "success";
        }
        $this->_out($response);
    }

    public function create_post() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        $member = $this->check_auth();
        if (!empty($this->request['content'])) {
            if (!empty($this->request['expiry_date'])) {
                $expiry_date = $this->request['expiry_date'];
            } else {
                $expiry_date = new DateTime();
                $expiry_date->modify("+1 day");
                $expiry_date = $expiry_date->format("Y-m-d H:i:s");
            }
            $latitude = $this->request['latitude'];
            $longitude = $this->request['longitude'];

            $rad = 10; // radius of bounding circle in kilometers

            $R = 6371;  // earth's mean radius, km
            // first-cut bounding box (in degrees)
            $maxLat = $latitude + rad2deg($rad / $R);
            $minLat = $latitude - rad2deg($rad / $R);
            // compensate for degrees longitude getting smaller with increasing latitude
            $maxLon = $longitude + rad2deg($rad / $R / cos(deg2rad($latitude)));
            $minLon = $longitude - rad2deg($rad / $R / cos(deg2rad($latitude)));

            $post_id = $this->admin->addPost([
                "member_id" => $member['member_id'],
                "content" => $this->request['content'],
                "latitude" => $this->request['latitude'],
                "longitude" => $this->request['longitude'],
                "expiry_date" => $expiry_date,
                "minlat" => $minLat,
                "minlon" => $minLon,
                "maxlat" => $maxLat,
                "maxlon" => $maxLon,
                "is_active" => "1"
            ]);
            $response['response'] = "true";
            $response['status'] = "success";
            $response['message'] = "Your Post has been published.";
            $response['data']['post_id'] = $post_id;
        }
        $this->_out($response);
    }

    public function myposts() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        $member = $this->check_auth();
        $response['data']['posts'] = $this->admin->searchPosts([
            "member_id" => $member['member_id']
        ]);
        $response['response'] = "true";
        $response['status'] = "success";
        $this->_out($response);
    }

    public function member_posts() {
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['message'] = "";
        $response['errors'] = [];
        $response['data'] = [];
        $member = $this->check_auth();
        $response['data']['posts'] = $this->admin->searchMemberPosts([
            "member_id" => $member['member_id']
        ]);
        $response['response'] = "true";
        $response['status'] = "success";
        $this->_out($response);
    }

    private function check_auth() {
        if (!empty($this->request['auth_token'])) {
            $member = $this->admin->checkMenerAuthToken($this->request['auth_token']);
            if (!empty($member['member_id'])) {
                return $member;
            }
        }
        $response = [];
        $response['response'] = "false";
        $response['status'] = "faild";
        $response['errors']['auth_token'] = "Invalid token";
        $this->_out($response);
        exit;
    }

    public function campaign() {        
        $response = [];
        $response['response'] = "false";
        $this->request = $_GET;
        if (!empty($this->request['name']) || !empty($this->request['email'])) {
            $pdata = [];
            $pdata['name'] = !empty($this->request['name']) ? $this->request['name'] : "";
            $pdata['email'] = !empty($this->request['email']) ? $this->request['email'] : "";
            $pdata['gender'] = !empty($this->request['gender']) ? $this->request['gender'] : "";
            $pdata['location'] = !empty($this->request['location']) ? $this->request['location'] : "";
            $this->admin->addCampaignData($pdata);
            $response['response'] = "true";
        }
        header('Content-type: application/x-javascript');
        echo $_GET['callback']."([".json_encode($response)."])";
        //$this->_out($response);
    }

    public function countries() {
        $countries = $this->admin->getCountriesList();
        $response = [];
        $response['data']['countries'] = $countries;
        $this->_out($response);
    }

}
