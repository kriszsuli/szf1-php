<?php
    session_start();
    
    function get_cookie_array() {
        if (isset($_COOKIE["tasks"]) && !empty($_COOKIE["tasks"])) {
            $decoded_json = base64_decode($_COOKIE["tasks"]);
            $json_data = json_decode($decoded_json, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($json_data)) {
                return $json_data;
            }
        }
        
        return array();
    }

    function add_task($arr) {
        $tasks = get_cookie_array();
        array_push($tasks, $arr);
        save_cookie_array($tasks);
    }
    
    function save_cookie_array($arr) {
        if (!isset($arr)) return error_log("Array not set as parameter");
        setcookie("tasks", htmlspecialchars(base64_encode(json_encode($arr))), time() + 3600 * 24 * 30);
    }
?>
