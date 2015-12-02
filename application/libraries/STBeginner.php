<?php

include 'Boom.php';

class STBeginner extends Boom {

    public $user_id = null;
    public $body_weight = "";
    public $user_session = "";
    public $user = [];
    private $CI;
    public $session_mode_order = array(
        "A_TEST" => ['WARMUP', 'BENCH_PRESS_TEST', 'SQUAT_TEST'],
        "B_TEST" => ['WARMUP', 'STANDING_PRESS_TEST', 'DEADLIFT_TEST'],
        "A_SESSION" => ['WARMUP', 'BENCH_PRESS_WARMUP', 'BENCH_PRESS', 'SQUAT_WARMUP', 'SQUAT'],
        "B_SESSION" => ['WARMUP', 'STANDING_PRESS_WARMUP', 'STANDING_PRESS', 'DEADLIFT_WARMUP', 'DEADLIFT']
    );
    public $session_mode_method = array(
        "WARMUP" => "warmup",
        "BENCH_PRESS_TEST" => "test",
        "SQUAT_TEST" => "test",
        "STANDING_PRESS_TEST" => "test",
        "DEADLIFT_TEST" => "test",
        "BENCH_PRESS_WARMUP" => "barbell_warmup",
        "SQUAT_WARMUP" => "barbell_warmup",
        "STANDING_PRESS_WARMUP" => "barbell_warmup",
        "DEADLIFT_WARMUP" => "barbell_warmup",
        "BENCH_PRESS" => "",
        "SQUAT" => "",
        "STANDING_PRESS" => "",
        "DEADLIFT" => ""
    );
    private $now_session_id = "";
    private $now_session_type = "";
    public $now_session_mode = "";
    private $now_session_round_cnt = 0;
    private $now_session_round_set_cnt = 0;
    private $now_session_round_feel = "";
    private $now_session_prev_round_feel = "";
    private $now_session_set_cnt = 0;
    public $equipments = [];
    public $exercise = [];
    public $feels = [];

    public function __construct($user_id = '') {
        parent::__construct();
        if (!empty($user_id)) {
            $this->user_id = $user_id;
        }
        $this->CI = & get_instance();
        if (!isset($this->CI->dbapi)) {
            $this->CI->load->model("DBAPI", "dbapi", TRUE);
        }
        $this->CI->load->model("BeginnerModel", "BeginnerModel", TRUE);
    }

    public function startProgram() {
        $this->CI->dbapi->addUserProgram(['program_id' => '1', 'program_status' => 'Progress', 'user_id' => $this->user_id]);
        $this->now_session_type = "A_TEST";
        $this->now_session_mode = "WARMUP";
        $this->now_session_method = $this->session_mode_method[$this->now_session_mode];
        $this->now_session_id = $this->CI->BeginnerModel->addSession([
            'user_id' => $this->user_id,
            'session_date' => date("Y-m-d"),
            'session_cnt' => '1',
            'session_type' => $this->now_session_type,
            'session_mode' => $this->now_session_mode
        ]);
    }

    public function closeProgram() {
        
    }

    public function resetProgram() {
        $this->CI->BeginnerModel->reset($this->user_id);
    }

    public function nextSession() {
        $last_session = $this->CI->BeginnerModel->getLastSession($user_id);
        if ($last_session['session_status'] == "Completed") {
            $session_cnt = $last_session['session_cnt'] + 1;
            $last_session_type = $last_session['session_type'];
            if ($last_session_type == "A_SESSION") {
                $this->now_session_type = "B_SESSION";
            } else if ($last_session_type == "B_SESSION") {
                $this->now_session_type = "A_SESSION";
            } else if ($last_session_type == "A_TEST") {
                $this->now_session_type = "B_TEST";
            } else if ($last_session_type == "B_TEST") {
                $this->now_session_type = "A_SESSION";
            } else {
                $this->now_session_type = "A_TEST";
            }
            $this->now_session_mode = "WARMUP";
            $this->now_session_method = $this->session_mode_method[$this->now_session_mode];
            $this->now_session_id = $this->CI->BeginnerModel->addSession([
                'user_id' => $this->user_id,
                'session_date' => date("Y-m-d"),
                'session_cnt' => $session_cnt,
                'session_type' => $this->now_session_type,
                'session_mode' => $this->now_session_mode
            ]);
        }
    }

    public function nextMode($now_session_mode = '') {
        $mode_orders = $this->session_mode_order[$this->now_session_type];
        $mode_key = array_search($now_session_mode, $mode_orders);
        $mode_key = $mode_key + 1;
        if (isset($mode_orders[$mode_key])) {
            $this->now_session_mode = $mode_orders[$mode_key];
            $this->now_session_method = $this->session_mode_method[$this->now_session_mode];
            $this->CI->BeginnerModel->updateSession($this->now_session_id, [
                'session_mode' => $this->now_session_mode
            ]);
        } else if ($mode_key == count($mode_orders)) {
            $this->now_session_mode = "";
            $this->now_session_method = "test_done";
            $this->CI->BeginnerModel->updateSession($this->now_session_id, [
                'session_mode' => $this->now_session_mode,
                'session_status' => "Completed"
            ]);
        }
    }

    public function prevMode($now_session_mode = '') {
        $mode_orders = $this->session_mode_order[$this->now_session_type];
        $mode_key = array_search($now_session_mode, $mode_orders);
        $mode_key = $mode_key - 1;
        if (isset($mode_orders[$mode_key])) {
            $this->now_session_mode = $mode_orders[$mode_key];
            $this->now_session_method = $this->session_mode_method[$this->now_session_mode];
            $this->CI->BeginnerModel->updateSession($this->now_session_id, [
                'session_mode' => $this->now_session_mode
            ]);
        }
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
        $this->user = $this->CI->dbapi->getUserById($this->user_id);
        $last_session = $this->CI->BeginnerModel->getLastSession($this->user_id);
        if ($last_session === false) {
            
        } else if (!empty($last_session) && $last_session['session_status'] == "Completed") {
            
        } else if (!empty($last_session)) {
            $this->now_session_id = $last_session['session_id'];
            $this->now_session_type = $last_session['session_type'];
            $this->now_session_mode = $last_session['session_mode'];
            $this->now_session_method = $this->session_mode_method[$this->now_session_mode];
        }

        if ($this->now_session_type == "A_TEST" || $this->now_session_type == "B_TEST") {
            $last_session_round = $this->CI->BeginnerModel->getLastTestRound($this->user_id);
            if ($last_session_round === false) {
                $this->now_session_round_cnt = 1;
                $this->now_session_round_set_cnt = 1;
                $this->now_session_round_id = "";
                if (in_array($this->now_session_mode, array("BENCH_PRESS_TEST", "SQUAT_TEST", "STANDING_PRESS_TEST", "DEADLIFT_TEST"))) {
                    $this->now_session_round_id = $this->CI->BeginnerModel->addTestRound([
                        'user_id' => $this->user_id,
                        'session_id' => $this->now_session_id,
                        'session_mode' => $this->now_session_mode,
                        'round_cnt' => $this->now_session_round_cnt,
                        'round_set_cnt' => $this->now_session_round_set_cnt,
                    ]);
                }
            } else if (!empty($last_session_round) && $last_session_round['round_status'] == "Completed" && !empty($this->now_session_mode)) {
                $this->now_session_round_cnt = 1;
                $this->now_session_round_set_cnt = 1;
                $this->now_session_round_id = $this->CI->BeginnerModel->addTestRound([
                    'user_id' => $this->user_id,
                    'session_id' => $this->now_session_id,
                    'session_mode' => $this->now_session_mode,
                    'round_cnt' => $this->now_session_round_cnt,
                    'round_set_cnt' => $this->now_session_round_set_cnt,
                ]);
            } else if (!empty($last_session_round)) {
                $this->now_session_round_cnt = $last_session_round['round_cnt'];
                $this->now_session_round_feel = $last_session_round['round_feel'];
                $this->now_session_round_set_cnt = $last_session_round['round_set_cnt'];
            }
        }
        $last_session_lift = $this->CI->BeginnerModel->getLastSessionLift($this->user_id);
    }

    public function checkSessionStatus($user_id = "") {
        $responce = [
            "status" => "INVALID",
            "session_type" => "",
            "session_mode" => "",
            "session_method" => "",
            "message" => ""
        ];
        if (!empty($user_id)) {
            $this->user_id = $user_id;
        } else if (empty($user_id) && !empty($this->user_id)) {
            $user_id = $this->user_id;
        }
        if (!empty($user_id)) {
            $last_session = $this->CI->BeginnerModel->getLastSession($user_id);
            if (!empty($last_session)) {
                $last_session_time = new DateTime($last_session['session_date']);
                $last_session_time->format("Y-m-d H:i:s");
                $session_intervel = $last_session_time->diff(new DateTime());
                $session_intervel = $session_intervel->days;
                /*if ($last_session['session_status'] == "Completed" && $session_intervel < 2) {
                    $responce['status'] = "REST";
                } else*/ if ($last_session['session_status'] == "Completed") {
                    $responce['status'] = "END";
                    $session_cnt = $last_session['session_cnt'] + 1;
                    $last_session_type = $last_session['session_type'];
                    if ($last_session_type == "A_SESSION") {
                        $this->now_session_type = "B_SESSION";
                    } else if ($last_session_type == "B_SESSION") {
                        $this->now_session_type = "A_SESSION";
                    } else if ($last_session_type == "A_TEST") {
                        $this->now_session_type = "B_TEST";
                    } else if ($last_session_type == "B_TEST") {
                        $this->now_session_type = "A_SESSION";
                    } else {
                        $this->now_session_type = "A_TEST";
                    }
                    $this->now_session_mode = "WARMUP";
                    $this->now_session_method = $this->session_mode_method[$this->now_session_mode];
                    $this->now_session_id = $this->CI->BeginnerModel->addSession([
                        'user_id' => $this->user_id,
                        'session_date' => date("Y-m-d"),
                        'session_cnt' => $session_cnt,
                        'session_type' => $this->now_session_type,
                        'session_mode' => $this->now_session_mode
                    ]);
                } else {
                    $responce['status'] = "RUNNING";
                    $responce['session_type'] = $last_session['session_type'];
                    $responce['session_mode'] = $last_session['session_mode'];
                    $responce['session_method'] = $this->session_mode_method[$last_session['session_mode']];
                }
            } else {
                $responce['status'] = "NOT_STARTED";
            }
        }
        return $responce;
    }

    public function getSessionMode() {
        return $this->now_session_mode;
    }

    function getUser() {
        if (empty($this->user) && !empty($this->user_id)) {
            $this->user = $this->CI->dbapi->getUserById($this->user_id);
        }
        return $this->user;
    }

    public function testProcess($lift_test = []) {
        $this->now_session_round_cnt = !empty($lift_test['round_cnt']) ? $lift_test['round_cnt'] : "1";
        $this->now_session_round_set_cnt = !empty($lift_test['round_set_cnt']) ? $lift_test['round_set_cnt'] : "1";
        $round_feel = !empty($lift_test['round_feel']) ? $lift_test['round_feel'] : "";
        $lift_rep_done = !empty($lift_test['rep_done']) ? $lift_test['rep_done'] : "0";

        $this->now_session_round_id = $this->CI->BeginnerModel->addTestRound([
            'user_id' => $this->user_id,
            'session_id' => $this->now_session_id,
            'session_mode' => $this->now_session_mode,
            'round_cnt' => $this->now_session_round_cnt,
            'round_set_cnt' => $this->now_session_round_set_cnt
        ]);

        $exercise = $this->getTestExercise();
        $lift_type = str_replace("_TEST", "", $this->now_session_mode);
        $lift_no = ($lift_type == "STANDING_PRESS" || $lift_type == "DEADLIFT") ? "2" : "1";
        $lift_weight = !empty($exercise['sets'][$this->now_session_round_set_cnt]['weight']) ? $exercise['sets'][$this->now_session_round_set_cnt]['weight'] : "0.00";
        $lift_rep_cnt = !empty($exercise['sets'][$this->now_session_round_set_cnt]['rep']) ? $exercise['sets'][$this->now_session_round_set_cnt]['rep'] : "1";
        $lift_set_max = count($exercise['sets']);
        $lift_id = $this->CI->BeginnerModel->addSessionLift([
            'user_id' => $this->user_id,
            'session_id' => $this->now_session_id,
            'round_cnt' => $this->now_session_round_cnt,
            'lift_type' => $lift_type,
            'lift_no' => $lift_no,
            'lift_set_cnt' => $this->now_session_round_set_cnt,
            'lift_rep_cnt' => $lift_rep_cnt,
            'lift_rep_done' => $lift_rep_done,
            'lift_weight' => $lift_weight
        ]);
        if ($this->now_session_round_set_cnt >= $lift_set_max || $round_feel == "Hard") {
            /* $this->CI->BeginnerModel->updateTestRound($this->now_session_round_id, [
              'round_feel' => $round_feel,
              'round_status' => "Completed",
              ]); */
            $this->now_session_round_id = $this->CI->BeginnerModel->addTestRound([
                'user_id' => $this->user_id,
                'session_id' => $this->now_session_id,
                'session_mode' => $this->now_session_mode,
                'round_cnt' => $this->now_session_round_cnt,
                'round_set_cnt' => $this->now_session_round_set_cnt,
                'round_feel' => $round_feel,
                'round_status' => "Completed"
            ]);
            if ($this->now_session_round_cnt >= 5 || $round_feel == "Hard") {
                $this->nextMode($this->now_session_mode);
                if (!empty($this->now_session_mode)) {
                    $this->now_session_round_cnt = 1;
                    $this->now_session_round_set_cnt = 1;
                    $this->now_session_round_id = $this->CI->BeginnerModel->addTestRound([
                        'user_id' => $this->user_id,
                        'session_id' => $this->now_session_id,
                        'session_mode' => $this->now_session_mode,
                        'round_cnt' => $this->now_session_round_cnt,
                        'round_set_cnt' => $this->now_session_round_set_cnt
                    ]);
                }
            } else {
                $this->now_session_round_cnt += 1;
                $this->now_session_round_set_cnt = 1;
                $this->now_session_round_id = $this->CI->BeginnerModel->addTestRound([
                    'user_id' => $this->user_id,
                    'session_id' => $this->now_session_id,
                    'session_mode' => $this->now_session_mode,
                    'round_cnt' => $this->now_session_round_cnt,
                    'round_set_cnt' => $this->now_session_round_set_cnt
                ]);
            }
        } else {
            $this->now_session_round_set_cnt += 1;
            $this->CI->BeginnerModel->updateTestRound($this->now_session_round_id, [
                'round_set_cnt' => $this->now_session_round_set_cnt,
                'round_status' => "Running"
            ]);
        }
        //$this->now_session_method = "test";
    }

    public function getTestExercise() {
        $exercise = array();
        $test_rount_cnt = !empty($this->now_session_round_cnt) ? $this->now_session_round_cnt : "1";
        $test_rount_set_cnt = !empty($this->now_session_round_set_cnt) ? $this->now_session_round_set_cnt : "1";
        $test_round_feel = !empty($this->now_session_round_feel) ? $this->now_session_round_feel : 'Easy';
        $test_prev_round_feel = !empty($this->now_session_prev_round_feel) ? $this->now_session_prev_round_feel : 'Easy';
        $feels = array();
        if ($this->now_session_mode == "BENCH_PRESS_TEST" || $this->now_session_mode == "SQUAT_TEST" || $this->now_session_mode == "STANDING_PRESS_TEST") {
            $exercise = array(
                "name" => $this->now_session_mode,
                "lift_name" => $this->now_session_mode,
                "session_mode" => $this->now_session_mode,
                "session_set_cnt" => $test_rount_set_cnt,
                "workout_weight" => "0",
                "equipment" => "0"
            );
            switch ($test_rount_cnt) {
                case "1":
                    $exercise['round_cnt'] = "1";
                    $exercise["sets"] = array(
                        "1" => array(
                            "weight" => "45",
                            "rep" => "5",
                            "between_time" => "2 min"
                        ),
                        "2" => array(
                            "weight" => "45",
                            "rep" => "5",
                            "between_time" => "2 min"
                        ),
                        "3" => array(
                            "weight" => "45",
                            "rep" => "5",
                            "between_time" => "2 min"
                        )
                    );
                    $feels = array("Easy", "Medium", "Hard");
                    break;
                case "2":
                    $exercise['round_cnt'] = "2";
                    if ($test_round_feel == "Easy") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "75",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                        $feels = array("Easy", "Medium", "Hard");
                    } else if ($test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "55",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                        $feels = array("Medium", "Hard");
                    }
                    break;
                case "3":
                    $exercise['round_cnt'] = "3";
                    if ($test_prev_round_feel == "Easy" && $test_round_feel == "Easy") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "95",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                        $feels = array("Easy", "Medium");
                    } else if ($test_prev_round_feel == "Easy" && $test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "85",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "85",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "3" => array(
                                "weight" => "85",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    } else if ($test_prev_round_feel == "Easy" && $test_round_feel == "Hard") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "75",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "75",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    } else if ($test_prev_round_feel == "Medium" && $test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "65",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "65",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "3" => array(
                                "weight" => "65",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    } else if ($test_prev_round_feel == "Medium" && $test_round_feel == "Hard") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "55",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "55",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    }
                    break;
                case "4":
                    $exercise['round_cnt'] = "4";
                    if ($test_round_feel == "Easy") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "115",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                        $feels = array("Easy", "Medium");
                    } else if ($test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "95",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "95",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    }
                    break;
                case "5":
                    $exercise['round_cnt'] = "5";
                    if ($test_round_feel == "Easy") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "135",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "135",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "3" => array(
                                "weight" => "135",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    } else if ($test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "115",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "115",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    }
                    break;
            }
        } else if ($this->now_session_mode == "DEADLIFT_TEST") {
            $exercise = array(
                "name" => "Deadlift",
                "lift_name" => "DEADLIFT",
                "session_mode" => $this->now_session_mode,
                "session_set_cnt" => $test_rount_set_cnt,
                "workout_weight" => "0"
            );
            switch ($test_rount_cnt) {
                case "1":
                    $exercise['round_cnt'] = "1";
                    $exercise["sets"] = array(
                        "1" => array(
                            "weight" => "95",
                            "rep" => "5",
                            "between_time" => "2 min"
                        ),
                        "2" => array(
                            "weight" => "95",
                            "rep" => "5",
                            "between_time" => "2 min"
                        ),
                        "3" => array(
                            "weight" => "95",
                            "rep" => "5",
                            "between_time" => "2 min"
                        )
                    );
                    $feels = array("Easy", "Medium", "Hard");
                    break;
                case "2":
                    $exercise['round_cnt'] = "2";
                    if ($test_round_feel == "Easy") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "115",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                        $feels = array("Easy", "Medium", "Hard");
                    } else if ($test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "105",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                        $feels = array("Medium", "Hard");
                    }
                    break;
                case "3":
                    $exercise['round_cnt'] = "3";
                    if ($test_prev_round_feel == "Easy" && $test_round_feel == "Easy") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "135",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                        $feels = array("Easy", "Medium");
                    } else if ($test_prev_round_feel == "Easy" && $test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "125",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "125",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "3" => array(
                                "weight" => "125",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    } else if ($test_prev_round_feel == "Easy" && $test_round_feel == "Hard") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "115",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "115",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    } else if ($test_prev_round_feel == "Medium" && $test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "115",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "115",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "3" => array(
                                "weight" => "115",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    } else if ($test_prev_round_feel == "Medium" && $test_round_feel == "Hard") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "105",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "105",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    }
                    break;
                case "4":
                    $exercise['round_cnt'] = "4";
                    if ($test_round_feel == "Easy") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "155",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                        $feels = array("Easy", "Medium");
                    } else if ($test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "145",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "145",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "3" => array(
                                "weight" => "145",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    } else if ($test_round_feel == "Hard") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "135",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "135",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    }
                    break;
                case "5":
                    $exercise['round_cnt'] = "5";
                    if ($test_round_feel == "Easy") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "175",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "175",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "3" => array(
                                "weight" => "175",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    } else if ($test_round_feel == "Medium") {
                        $exercise["sets"] = array(
                            "1" => array(
                                "weight" => "155",
                                "rep" => "5",
                                "between_time" => "2 min"
                            ),
                            "2" => array(
                                "weight" => "155",
                                "rep" => "5",
                                "between_time" => "2 min"
                            )
                        );
                    }
                    break;
            }
        }
        $this->exercise = $exercise;
        $this->feels = $feels;
        return $exercise;
    }

    public function getBarbellWarmup() {
        $exercise = array(
            "mode" => "Barbell Warmups",
            "name" => "",
            "lift_name" => ""
        );
        $body_weight = $this->user['body_weight'];

        if ($lift_name == "SQUAT" && $lift_name == "DEADLIFT") {
            if ($body_weight <= 55) {
                $exercise['sets'] = [
                    "1" => ""
                ];
            } else if ($body_weight >= 60 && $body_weight <= 70) {
                
            } else if ($body_weight >= 75 && $body_weight <= 85) {
                
            } else if ($body_weight >= 90) {
                
            }// category end
        } else if ($lift_name == "BENCH_PRESS" && $lift_name == "STANDING_PRESS") {
            if ($body_weight <= 55) {
                $exercise['sets'] = [
                    "1" => ""
                ];
            } else if ($body_weight >= 60 && $body_weight <= 70) {
                
            } else if ($body_weight >= 75 && $body_weight <= 85) {
                
            } else if ($body_weight >= 90) {
                
            }// category end
        }
        return $exercise;
    }

}

// class end.
?>