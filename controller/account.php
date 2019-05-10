<?php
include_once BASE_PATH.'/util/mysql.php';
class User {

    /**
     * 
     */
    function get_user($base_url, $body) {
        $conn = get_connection();
        $sql = "select * from tb_user where user_name=? and password=?;";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            //绑定预处理参数
            $stmt->bind_param("ss", $user_name, $password);

            $user_name = $body['user_name'];
            $password = $body['password'];

            //绑定结果集 列->变量 未取数据
            $stmt->bind_result($user_name,$password,$sex,$age,$phone,$email,$job,$address);
            //执行预处理语句
            $stmt->execute();
            //从结果集中取数据
            $stmt->fetch();
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
            if (!empty($sex)) {
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
                var_dump($response);
            } else {
                $response = "无此用户";
            }
        }
        $stmt->close();
        $conn->close();
    }

    /**
     * 
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
        } else {
            $error = $conn->errno . ' ' . $conn->error;
            echo $error."<br/>";
        }
        $conn->close();
    }

    /**
     * 
     */
    function put_user($base_url, $body) {
        $conn = get_connection();
        if (count($body) > 0) {
            $sql = "update tb_user set ";
        }
        
        //拼接需要修改的属性 $sql
        foreach($body as $k => $v) {
            $sql = $sql . "$k = '$v',"; 
            echo "$k"."=>"."$v"."<br/>";
        }
        $sql = rtrim($sql, ',')." where user_name='shabulaji';";
        echo $sql;
        $conn->query($sql);
        $conn->close();
    }

    /**
     * 
     */
    function patch_user() {

    }
}
?>