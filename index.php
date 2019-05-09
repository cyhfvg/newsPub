<?php
// include_once(dirname(__FILE__).'/util/url.php');
// include_once(dirname(__FILE__).'/util/request.php');
//重定向至登录页面
// $url = get_cur_url().'/view/login.php';
// do_request($url,array());
?>

<?php
//权限控制
// include_once(dirname(__FILE__).'../auth.php');
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
// $router = include_once BASE_PATH.'/router/router.php';
include_once BASE_PATH.'/router/router.php';
// var_dump($router);

$uri = $_SERVER['PHP_SELF'];
$url = explode('/', $uri);
$url[1] = '';
// var_dump($url);
array_shift($url);

$request_path = implode('/', $url);
$request_path = str_replace('index.php', '', $request_path);
// echo $request_path.'<br/>';
// $request_query = getCurrentQuery();
if (array_key_exists($request_path, $router)) {
    $module_file = BASE_PATH.$router[$request_path]['file_name'];
    $class_name = $router[$request_path]['class_name'];
    $method_name = $router[$request_path]['method_name'];
    include BASE_PATH.'/util/rest.php';
    $method_name = $method_name.get_request_type();
    // echo $module_file.':'.$class_name.'->'.$method_name.'<br/>';
    if (file_exists($module_file)) {
        include $module_file;
        $obj_module = new $class_name();
        if (!method_exists($obj_module, $method_name)) {
            die('调用方法不存在!');
        } else {
            if (is_callable(array($obj_module, $method_name))) {
                $obj_module->$method_name('hello ', 'world');
            }
        }
    } else {
        die('定义的模块不存在!');
    }
} else {
    echo "页面不存在！";
}
?>