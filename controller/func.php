<?php
include_once BASE_PATH.'/util/request.php';
include_once BASE_PATH.'/controller/account.php';

class Func {
    /**
     * 获取登录页api get
     */
    function get_pass_login($base_url) {
        header("location:$base_url/view/login.html");
    }

    function post_pass_api_get_user($base_url, $body) {
        // $body = json_decode($body);
        // do_request($base_url.'/account', $body, 'GET');
        $user = new User();
        $user->get_user($base_url, $body);
    }

}
?>