<?php
include_once dirname(__FILE__).'/util/request.php';
function get_auth() {
    session_start();
    if (!isset($_SESSION['user_name'])) {
        do_request('./index.php', array(), 'GET');
    }
}

?>