<?php
//权限控制
// include_once(dirname(__FILE__).'./auth.php');
//项目根目录
date_default_timezone_set("Asia/Shanghai");
header("Content-type:text/html;charset=utf-8");
//项目根目录
define("BASE_PATH", dirname(__FILE__));
//调试模式
define('APP_DEBUG', TRUE);
//引入配置文件
include_once BASE_PATH.'/config/config.php';
//路由控制
$router = include_once BASE_PATH.'/router/router.php';

$req_path = get_request_path();
$request_path = $req_path['request_path'];
$project = $req_path['project'];

// if ($request_path != '/') {
//     get_auth();
// }

// echo $request_path.'<br/>';
if (array_key_exists($request_path, $router)) {
    $module_file = BASE_PATH.$router[$request_path]['file_name'];
    $class_name = $router[$request_path]['class_name'];
    $method_name = $router[$request_path]['method_name'];
    include BASE_PATH.'/util/rest.php';
    $request = get_request();
    $method_name = $request['type'].$method_name;
    // echo $module_file.':'.$class_name.'->'.$method_name.'<br/>';
    if (file_exists($module_file)) {
        include $module_file;
        $obj_module = new $class_name();
        if (!method_exists($obj_module, $method_name)) {
            die('调用方法不存在!');
        } else {
            if (is_callable(array($obj_module, $method_name))) {
                $base_url = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/'.$project;
                //如果是get方式传参，则将参数键值对传入body
                if (!empty($req_path['get_body'])) {
                    $request['body'] = $req_path['get_body'];
                }
                //调用指定模块的指定方法
                $obj_module->$method_name($base_url, $request['body']);
            }
        }
    } else {
        die('定义的模块不存在!');
    }
} else {
    echo "页面不存在！";
}
function get_request_path() {
    $req_path = array(
        "project" => "",
        "request_path" => "",
        "get_body" => array()

    );
    //获取uri
    $uri = $_SERVER['REQUEST_URI'];

    $temp = explode('?', $uri);
    $uri = $temp[0];
    //获取 get 方式url传递的参数
    if (isset($temp[1])) {
        $params = $temp[1];
        $k_v = explode('&', $params);

        for($i = 0; $i < count($k_v); $i ++) {
            $key = explode('=' , $k_v[$i])[0];
            $value = explode('=', $k_v[$i])[1];
            $req_path['get_body'][$key] = $value;
        }
    }

    $url = explode('/', $uri);
    $project = $url[1];
    $req_path['project'] = $url[1];
    $url[1] = '';
    // var_dump($url);
    array_shift($url);

    //获取请求url
    $request_path = implode('/', $url);
    $request_path = str_replace('index.php', '', $request_path);

    $req_path['request_path'] = $request_path;
    // var_dump($req_path);
    return $req_path;
}
?>