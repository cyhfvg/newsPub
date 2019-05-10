<?php
function get_request() {
    $result = array(
        "type" => '',
        "body" => array()
    );
    if (is_get()) {
        // $request_path = 'get_';
        // $request = $_GET;
        $result['type'] = 'get_';
        $result['body'] = get_request_body();
    } else if(is_post()) {
        $result['type'] = 'post_';
        $result['body'] = get_request_body();
    } else if (is_patch()) {
        $result['type'] = 'patch_';
        $result['body'] = get_request_body();
    } else if (is_delete()) {
        $result['type'] = 'delete_';
        $result['body'] = get_request_body();
    } else if(is_put()) {
        $result['type'] = 'put_';
        // parse_str(file_get_contents('php://input'), $_PUT);
        $result['body'] = get_request_body();
    }
    return $result;
}

function get_request_body() {
    $data = file_get_Contents('php://input');
    $data_obj = json_decode($data);
    $data_arr = json_decode($data, true);
    return $data_arr;
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