<?php

if (!function_exists("getMessage")) {

    function getMessage($sub = '') {
        if (!empty($sub) && !empty($_SESSION[$sub]['message'])) {
            echo '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">×</button> ' . $_SESSION[$sub]['message'] . '</div>';
            $_SESSION[$sub]['message'] = "";
        }// if end.
        if (empty($sub) && !empty($_SESSION['message'])) {
            echo '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">×</button> ' . $_SESSION['message'] . '</div>';
            $_SESSION['message'] = "";
        }// if end.
        if (!empty($sub) && !empty($_SESSION[$sub]['error'])) {
            echo '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> ' . $_SESSION[$sub]['error'] . '</div>';
            $_SESSION[$sub]['error'] = "";
        }// if end.
        if (empty($sub) && !empty($_SESSION['error'])) {
            echo '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> ' . $_SESSION['error'] . '</div>';
            $_SESSION['error'] = "";
        }// if end.
    }

}

if (!function_exists("generatePassword")) {

    function generatePassword($length = 8) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        //'0123456789``-=~!@#$%^&*()_+,./<>?;:[]{}\|';
        $str = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++)
            $str .= $chars[rand(0, $max)];
        return $str;
    }

}

if (!function_exists("generateOTP")) {

    function generateOTP($length = 8) {
        $chars = '0123456789';
        $str = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++)
            $str .= $chars[rand(0, $max)];
        return $str;
    }

}

if (!function_exists("dateDB2SHOW")) {

    function dateDB2SHOW($db_date = "", $display = "") {
        if (!empty($db_date) && $db_date != "0000-00-00" && $db_date != "0000-00-00 00:00:00") {
            $db_date = strtotime($db_date);
            return date("d/m/Y", $db_date);
        }
        return $display;
    }

}

if (!function_exists("dateTimeDB2SHOW")) {

    function dateTimeDB2SHOW($db_date = "", $format = "", $display = "") {
        if (!empty($db_date) && $db_date != "0000-00-00" && $db_date != "0000-00-00 00:00:00") {
            $db_date = strtotime($db_date);
            if (!empty($format)) {
                return date($format, $db_date);
            } else {
                return date("m/d/Y h:i A", $db_date);
            }
        }
        return $display;
    }

}

if (!function_exists("dateForm2DB")) {

    function dateForm2DB($frm_date) {
        $frm_date = explode("/", $frm_date);
        if (!empty($frm_date[0]) && !empty($frm_date[1]) && !empty($frm_date[2])) {
            return $frm_date[2] . "-" . $frm_date[1] . "-" . $frm_date[0];
        } else {
            return "";
        }
    }

}

if (!function_exists("dateTimeForm2DB")) {

    function dateTimeForm2DB($frm_date) {
        $frm_date_time = explode(" ", $frm_date);
        $frm_date = explode("/", $frm_date_time[0]);
        $frm_time = explode(":", $frm_date_time[1]);
        if (!empty($frm_date[0]) && !empty($frm_date[1]) && !empty($frm_date[2])) {
            if (!isset($frm_time[0]))
                $frm_time[0] = "00";
            if (!isset($frm_time[1]))
                $frm_time[1] = "00";
            if (!isset($frm_time[2]))
                $frm_time[2] = "00";
            return $frm_date[2] . "-" . $frm_date[0] . "-" . $frm_date[1] . " " . $frm_time[0] . ":" . $frm_time[1] . ":" . $frm_time[2];
        } else {
            return "";
        }
    }

}

if (!function_exists("priceFormat")) {

    function priceFormat($price) {
        return number_format($price, 2);
    }

}

if (!function_exists("stdNameFormat")) {

    function stdNameFormat($str, $space = '-') {
        $str = strtolower($str);
        $str = str_replace("  ", " ", $str);
        $str = str_replace(" ", $space, $str);
        return $str;
    }

}

if (!function_exists("stdURLFormat")) {

    function stdURLFormat($str, $space = '-') {
        $str = strtolower($str);
        $str = preg_replace('/[^a-zA-Z0-9\-\ ]/i', '', $str);
        $str = str_replace("  ", " ", $str);
        $str = str_replace(" ", $space, $str);
        return $str;
    }

}

if (!function_exists("shortDesc")) {

    function shortDesc($str, $len = 300) {
        $str = substr($str, 0, $len);
        return $str;
    }

}

function curl_get_contents($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

if (!function_exists("getIPInfo")) {

    function getIPInfo($ip = '') {
        if (empty($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return json_decode(curl_get_contents("http://ipinfo.io/{$ip}/json"));
    }

}

if (!function_exists("geoDistance")) {

    function geoDistance($lat1, $lon1, $lat2, $lon2, $unit = "K") {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
}
?>