<?php
class Login {
    /**
     * 获取登录页api get
     */
    function get_login($base_url) {
        header("location:$base_url/view/login.php");
    }

}
?>