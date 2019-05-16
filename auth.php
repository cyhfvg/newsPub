<?php
include_once dirname(__FILE__).'/util/request.php';
function get_auth($base_url) {
    session_start();
    if (!isset($_SESSION['user_name'])) {

        // header("Content-Type: text/html; charset=utf-8");
        // header('HTTP/1.1 401 Unauthorized');
        // do_request('./index.php', array(), 'GET');
        // header("location:http://localhost/newsPub/index.php");
        // header('WWW-Authenticate: Basic realm="Top Secret"');
        exit;
    }
}

?>