<?php
/**
 * 获取此次请求的类型(GET,POST,PUT,DELETE)
 * 获取此次请求的数据体
 * 
 * @return array $result $result['type]=[get_|post_|patch_|delete_|put_];$result['body] is array;
 */
function get_request() {
    $result = array(
        "type" => '',
        "body" => array()
    );
    if (is_get()) {
        $result['type'] = 'get_';
        $result['body'] = get_request_body();
        // $result['body'] = $_GET;
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
        $result['body'] = get_request_body();
    }
    return $result;
}

/**
 * 此函数获取此次请求的数据体
 * 
 * @return array $data_arr [$_GET|$_POST|PUT]
 */
function get_request_body() {
    $data = file_get_Contents('php://input');
    $data_obj = json_decode($data);
    $data_arr = json_decode($data, true);
    //生产模式
    // echo "/util/rest.php===请求参数：<br/>";
    // var_dump($data_arr);
    // echo "<br/>";
    return $data_arr;
}

/**
 * 判断此次请求是否为POST提交方式
 * 
 * @return boolean [true|false]
 */
function is_post() {
    //创建 create
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
}

/**
 * 判断此次请求是否为GET提交方式
 * 
 * @return boolean [true|false]
 */
function is_get() {
    //获取 select
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'GET';
}

/**
 * 判断此次请求是否为DELETE提交方式
 * 
 * @return boolean [true|false]
 */
function is_delete() {
    //删除 delete
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'DELETE';
}

/**
 * 判断此次请求是否为PUT提交方式
 * 
 * @return boolean [true|false]
 */
function is_put() {
    //更新 完整更新
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'PUT';
}

/**
 * 判断此次请求是否为PATCH提交方式
 * 
 * @return boolean [true|false]
 */
function is_patch() {
    //更新 更新属性
    return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'PATCH';
}
?>