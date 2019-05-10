<?php
/**
 * 从配置文件中，获取指定的mysql数据库的一个连接
 * 配置文件位于[Project_Site]/config/config.php
 * @return object $conn mysql连接对象
 */
function get_connection() {
    $mysql_info = include BASE_PATH.'/config/config.php';
    // $mysql_info = include dirname(__FILE__).'/../config/config.php';

    $server_name = $mysql_info['mysql_info']['server_name'];
    $user_name = $mysql_info['mysql_info']['user_name'];
    $password = $mysql_info['mysql_info']['password'];
    $db_name = $mysql_info['mysql_info']['database_name'];
    $port = $mysql_info['mysql_info']['port'];

    $conn = mysqli_connect($server_name, $user_name, $password, $db_name, $port);
    if (!$conn) {
        echo $server_name.$db_name;
        die("Connection failed: " . mysqli_connect_error());
    } else {
        //获得连接成功 设置字符集为utf8
        mysqli_set_charset($conn, 'utf8');
        echo "<br/>连接成功<br/>";
    }
    return $conn;
}
?>