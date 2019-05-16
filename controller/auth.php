<?php
class Auth {
    function get_auth($base_url, $body) {
        session_start();
        if (!isset($_SESSION['user_name'])) {
            echo json_encode(array('auth' => 'none'));
        } else {
            echo json_encode(array(
                'auth' => 'pass',
                'user_name' => $_SESSION['user_name'],
                'user_password' => $_SESSION['user_password']
            ));
        }
    }
}
?>