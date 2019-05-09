<?php
/**
 * 从配置文件中，获取指定的mysql数据库的一个连接
 * 配置文件位于[Project_Site]/config/mysql_conf.php
 * @return object $conn mysql连接对象
 */
function get_conn() {
    include_once(dirname(__FILE__)."/../config/mysql_conf.php");

    $mysql_info = new Mysql_info();

    $server_name = $mysql_info->db_server_name;
    $user_name = $mysql_info->db_user_name;
    $password = $mysql_info->db_password;
    $db_name = $mysql_info->db_name;
    $port = $mysql_info->port;

    $conn = mysqli_connect($server_name, $user_name, $password, $db_name, $port);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        //获得连接成功 设置字符集为utf8
        mysqli_set_charset($conn, 'utf8');
    }
    return $conn;
}

?>