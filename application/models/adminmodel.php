<?php

class AdminModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function searchMemberPosts($s = array(), $mode = "DATA") {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.post_id, m.content, m.dist, u.name AS posted_by, m.latitude, m.longitude, m.expiry_date");
        }
        if (!empty($s['member_id'])) {
            $this->db->where("m.member_id", $s['member_id']);
        }
        $this->db->join("tbl_members u", "m.posted_by = u.member_id", "left");
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        }
        $this->db->order_by("m.dist DESC");
        $query = $this->db->get("view_member_posts m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return [];
    }

    function searchPosts($s = array(), $mode = "DATA") {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {            
            $this->db->select("m.*, u.name AS posted_by");
            $this->db->join("tbl_members u", "m.member_id = u.member_id", "left");
        }
        if (!empty($s['member_id'])) {
            $this->db->where("m.member_id", $s['member_id']);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        }
        $this->db->order_by("m.post_id DESC");
        $query = $this->db->get("tbl_posts m");

        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return [];
    }

    // member GEO lotion
    function updateMemberGeo($member_id, $pdata) {
        $this->db->where("member_id", $member_id);
        return $this->db->update("tbl_member_geo", $pdata);
    }

    // Posts 
    function addPost($pdata) {
        if (empty($pdata['post_date'])) {
            $this->db->set("post_date", "NOW()", false);
        }
        $this->db->insert("tbl_posts", $pdata);
        return $this->db->insert_id();
    }

    function updatePost($post_id, $pdata) {
        $this->db->where("post_id", $post_id);
        return $this->db->update("tbl_posts", $pdata);
    }

    function delPost($post_id) {
        $this->db->where("post_id", $post_id);
        return $this->db->delete("tbl_posts");
    }

    function getPostById($post_id) {
        $this->db->select("*");
        $this->db->where("post_id", $post_id);
        $query = $this->db->get("tbl_posts");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    //Rating
    function addMemberRating($member_id, $rating_by, $rating = '0') {
        $this->db->select("m.*");
        $this->db->where("member_id", $member_id);
        $this->db->where("rating_by", $rating_by);
        $query = $this->db->get("tbl_ratings m");
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $this->db->where("member_id", $row['member_id']);
            return $this->db->update("tbl_ratings", ['raring' => $rating]);
        } else {
            $this->db->insert("tbl_ratings", [
                'member_id' => $member_id,
                'rating_by' => $rating_by,
                'rating' => $rating
            ]);
            return $this->db->insert_id();
        }
        return false;
    }

    // review
    function addMemberReview($member_id, $reviewed_by, $review) {
        $this->db->set("created_on", "NOW()", false);
        $this->db->insert("tbl_reviews", [
            "member_id" => $member_id,
            "reviewed_by" => $reviewed_by,
            "review" => $review
        ]);
        return $this->db->insert_id();
    }

    // Member 
    function addMember($pdata) {
        $this->db->set("created_on", "NOW()", false);
        $this->db->insert("tbl_members", $pdata);
        return $this->db->insert_id();
    }

    function updateMember($member_id, $pdata) {
        $this->db->where("member_id", $member_id);
        return $this->db->update("tbl_members", $pdata);
    }

    function delMember($member_id) {
        $this->db->where("member_id", $member_id);
        return $this->db->delete("tbl_members");
    }

    function getMemberById($member_id) {
        $this->db->select("*");
        $this->db->where("member_id", $member_id);
        $query = $this->db->get("tbl_members");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function searchMembers($s = array(), $mode = "DATA") {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        }
        $this->db->order_by("m.member_id DESC");
        $query = $this->db->get("tbl_members m");

        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function checkMemberEmail($email, $member_id = '') {
        $this->db->select("email");
        $this->db->where("email", $email);
        if (!empty($member_id)) {
            $this->db->where("member_id !=", $member_id);
        }
        $query = $this->db->get("tbl_members");
        return $query->num_rows();
    }

    function getMemberByEmail($email) {
        $this->db->select("*");
        $this->db->where("email", $email);
        $query = $this->db->get("tbl_members");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function memberLogin($email, $pwd) {
        $this->db->select("*");
        $this->db->where("email", $email);
        $this->db->where("pwd", $pwd);
        $query = $this->db->get("tbl_members");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function checkMenerAuthToken($token) {
        $this->db->select("member_id, name, email, mobile, otp_code, auth_token");
        $this->db->where("auth_token", $token);
        $query = $this->db->get("tbl_members");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    // Countries
    function addCountry($pdata) {
        $this->db->insert("tbl_countries", $pdata);
        return $this->db->insert_id();
    }

    function updateCountry($pdata, $country_id) {
        $this->db->where("country_id", $country_id);
        return $this->db->update("tbl_countries", $pdata);
    }

    function delCountry($country_id) {
        $this->db->where("country_id", $country_id);
        return $this->db->delete("tbl_countries");
    }

    function getCountryById($country_id) {
        $this->db->select("m.*");
        $this->db->where("country_id", $country_id);
        $query = $this->db->get("tbl_countries m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function searchCountries($s = array(), $mode = "DATA") {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        }
        $this->db->order_by("m.country_id ASC");
        $query = $this->db->get("tbl_countries m");

        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getCountriesList() {
        $this->db->select("m.country_id, country_code, country_name");
        $query = $this->db->get("tbl_countries m");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // Categories
    function addCategory($pdata) {
        $this->db->insert("tbl_categories", $pdata);
        return $this->db->insert_id();
    }

    function updateCategory($pdata, $category_id) {
        $this->db->where("category_id", $category_id);
        return $this->db->update("tbl_categories", $pdata);
    }

    function delCategory($category_id) {
        $this->db->where("category_id", $category_id);
        return $this->db->delete("tbl_categories");
    }

    function getCategoryById($category_id) {
        $this->db->select("m.*");
        $this->db->where("category_id", $category_id);
        $query = $this->db->get("tbl_categories m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function searchCategories($s = array(), $mode = "DATA") {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        }
        $this->db->order_by("m.category_id DESC");
        $query = $this->db->get("tbl_categories m");

        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getCategoriesList() {
        $this->db->select("m.*");
        $query = $this->db->get("tbl_categories m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['category_id']] = $row['category_name'];
            }
            return $rows;
        }
        return false;
    }
    
    function addCampaignData($pdata) {
        $this->db->insert("tbl_social_campaign", $pdata);
        return $this->db->insert_id();
    }

    //Admin
    function addAdmin($pdata) {
        return $this->db->insert("tbl_admin", $pdata);
    }

    function updateAdmin($pdata, $admin_id) {
        $this->db->where("admin_id", $admin_id);
        return $this->db->update("tbl_admin", $pdata);
    }

    function getAdminById($admin_id) {
        $this->db->select("m.*");
        $this->db->where("admin_id", $admin_id);
        $query = $this->db->get("tbl_admin m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function checkAdminEmail($email, $admin_id = '') {
        $this->db->select("email");
        $this->db->where("email", $email);
        if (!empty($admin_id))
            $this->db->where("admin_id !=", $admin_id);
        $query = $this->db->get("tbl_admin");
        return $query->num_rows();
    }

    function adminLogin($email, $pwd) {
        $this->db->select("*");
        $this->db->where("email", $email);
        $this->db->where("pwd", $pwd);
        $query = $this->db->get("tbl_admin");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

}

?>