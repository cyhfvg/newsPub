<?php
include_once BASE_PATH.'/util/mysql.php';
/**
 * User 类提供相应各种请求类型的有关 user 的对应处理方法
 * @method get_user(@param String $base_url, @param array $body)
 * @method post_user(@param String $base_url, @param array $body)
 * @method put_user(@param String $base_url, @param array $body)
 * @method patch_user(@param String $base_url, @param array $body)
 */
class User {
    /**
     * 方法响应GET方式请求/account
     * 获取user信息
     * 
     * @param String $base_url 项目基准url http://localhost/project
     * @param array $body 请求体
     */
    function get_user($base_url, $body) {
        //打印
        // var_dump($body);

        $conn = get_connection();
        $sql = "select * from tb_user where user_name=? and password=?;";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            //绑定预处理参数
            $stmt->bind_param("ss", $user_name, $password);

            $user_name = $body['user_name'];
            $password = $body['user_password'];

            //绑定结果集 列->变量 未取数据
            $stmt->bind_result($user_name,$password,$sex,$age,$phone,$email,$job,$address);
            //执行预处理语句
            $stmt->execute();
            //从结果集中取数据
            // $stmt->fetch();

            //查询结果集 多条记录
            // while ($stmt->fetch()) {
            //     echo $user_name;
            // }
            //
            // $response = array(
            //     'user_name' => $user_name,
            //     'sex' => $sex,
            //     'age' => $age,
            //     'phone' => $phone,
            //     'email' => $email,
            //     'job' => $job,
            //     'address' => $address
            // );
            if ($stmt->fetch()) {
                $response = array(
                    'user_name' => $user_name,
                    'sex' => $sex,
                    'age' => $age,
                    'phone' => $phone,
                    'email' => $email,
                    'job' => $job,
                    'address' => $address
                );
                //处理返回客户端
                // var_dump($response);
                $sql = "select role_id from tb_u_r where user_name = $user_name;";
                $result =  $conn->query($sql);
                if ($row -> $result->fetch_assoc()) {
                    $response['role'] = $row['role_id'];
                }
                echo json_encode($response);
            } else {
                $response = 'error';
                echo json_encode($response);
            }
        }
        $stmt->close();
        $conn->close();
    }

    /**
     * 方法响应POST方式请求/account
     * 新增user
     * 
     * @param String $base_url 项目基准url http://localhost/project
     * @param array $body 请求体
     */
    function post_user($base_url, $body) {
        $conn = get_connection();
        $sql = "insert into tb_user (user_name, password, sex, age, phone, email, job, address) 
            values (?, ?, ?, ?, ?, ?, ?, ?);";
        //预处理及绑定
        $stmt = $conn->prepare($sql);
        // var_dump($stmt);
        if ($stmt) {
            $stmt->bind_param("sssissss", $user_name, $password, $sex, $age, 
                $phone, $email, $job, $address);

            $user_name = $body['user_name'] ;
            $password = $body['user_password'];
            $sex = $body['user_sex'];
            $age = $body['user_age'];
            $phone = $body['user_phone'];
            $email = $body['user_email'];
            $job = $body['user_job'];
            $address = $body['user_address'];
            $stmt->execute();
            $stmt->close();
            var_dump($body);
            echo json_encode(array("status" => "OK"));
        } else {
            $error = $conn->errno . ' ' . $conn->error;
            echo $error."<br/>";
        }
        $conn->close();
    }

    /**
     * 方法响应PUT方式请求/account
     * 更新user信息
     * 
     * @param String $base_url 项目基准url http://localhost/project
     * @param array $body 请求体
     */
    function put_user($base_url, $body) {
        $conn = get_connection();
        if (count($body) > 0) {
            $sql = "update tb_user set ";
        }
        
        //拼接需要修改的属性 $sql
        foreach($body as $k => $v) {
            if ($k != 'auth_user_name' && $k != 'auth_user_password') {
                $sql = $sql . "$k = '$v',"; 
                // echo "$k"."=>"."$v"."<br/>";
            }
        }
        //TODO: 需要修改where条件为动态条件
        $auth_user_name = $body['auth_user_name'];
        $auth_user_password = $body['auth_user_password'];
        $sql = rtrim($sql, ',')." where user_name='$auth_user_name' and password='$auth_user_password';";
        echo $sql;
        $conn->query($sql);
        $conn->close();
    }

    /**
     * 方法响应PATCH方式请求/account
     * 更新user信息
     * !方法弃用
     * 
     * @param String $base_url 项目基准url http://localhost/project
     * @param array $body 请求体
     */
    function patch_user() {

    }
}
?>