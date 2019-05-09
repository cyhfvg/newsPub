<?php
function get_request_type() {
    $request_type = '';
    if (is_get()) {
        $request_path = '_get';
    } else if(is_post()) {
        $request_path = '_post';
    } else if (is_patch()) {
        $request_path = '_patch';
    } else if (is_delete()) {
        $request_path = '_delete';
    } else if(is_put()) {
        $request_path = '_put';
    }
    return $request_path;
}

function is_post() {
    //创建 create
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
}
function is_get() {
    //获取 select
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'GET';
}
function is_delete() {
    //删除 delete
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'DELETE';
}
function is_put() {
    //更新 完整更新
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'PUT';
}
function is_patch() {
    //更新 更新属性
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'PATCH';
}
?>