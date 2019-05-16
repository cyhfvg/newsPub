<?php
//引入数据库操作辅助函数
include_once BASE_PATH.'/util/mysql.php';

/**
 * News 类 提供关于各种 http 请求的对应处理函数
 * @method get_new(@param String $base_url, @param array $body)
 * @method post_new(@param String $base_url, @param array $body)
 * @method put_new(@param String $base_url, @param array $body)
 * @method patch_new(@param String $base_url, @param array $body)
 */
class News{

    /**
     * 方法处理 对 /news 路径的 GET 方式处理，
     * 获取 news 信息
     * @param String $base_url 此次请求的基准url example:-> http://localhost/project
     * @param array $body 请求体(提交参数域)
     */
    function get_news($base_url, $body) {
        $conn = get_connection();

        $length = $body['limit'];
        $start = ($body['curPage'] - 1) * $length;

        // $sql = "select * from tb_news order by pub_date desc limit $start, $length;";
        $sql = "select * from tb_news order by pub_date desc;";
        $result = $conn->query($sql);

        //返回数据集
        $return_data = array();

        //查询到数据
        if ($result->num_rows > 0) {
            //数据放入返回数据集
            while ($row=$result->fetch_assoc()) {
                array_push($return_data, $row);
            }
        }

        //查询发生错误
        if (!$result) {
            $error = $conn->errno . ' ' . $conn->error;
            echo $error."<br/>";
        } else {
            echo json_encode($return_data);
        }
    }

    /**
     * 方法处理 对 /news 路径的 POST 方式处理，
     * 创建 news
     * @param String $base_url 此次请求的基准url example:-> http://localhost/project
     * @param array $body 请求体(提交参数域)
     */
    function post_news($base_url, $body) {
        $conn = get_connection();
        $sql = "insert into tb_news (title, body, pub_date) 
            values (?, ?, ?);";
        //预处理及绑定
        $stmt = $conn->prepare($sql);
        // var_dump($stmt);
        if ($stmt) {
            $stmt->bind_param("sss", $title, $news_body, $pub_date);

            $title= $body['news_title'];
            $news_body = $body['news_body'];
            $pub_date = $body['news_pub_date'];

            $stmt->execute();
            $stmt->close();

            $sql = "select last_insert_id();";
            $result = $conn->query($sql);
            $news_id = "";
            if ($row = $result->fetch_assoc()) {
                $news_id = $row['last_insert_id()'];
            }

            session_start();
            $user_name = $_SESSION['user_name'];
            $sql = "insert into tb_u_n (user_name, news_id) values('$user_name', $news_id);";
            $conn->query($sql);
            echo json_encode(array("status" => "OK"));
        } else {
            $error = $conn->errno . ' ' . $conn->error;
            echo $error."<br/>";
        }
        $conn->close();
    }

    /**
     * 方法处理 对 /news 路径的 PUT 方式处理，
     * 更新 news 信息
     * @param String $base_url 此次请求的基准url example:-> http://localhost/project
     * @param array $body 请求体(提交参数域)
     */
    function put_news($base_url, $body) {
        $conn = get_connection();
        if (count($body) > 0) {
            $sql = "update tb_news set ";
        }

        foreach($body as $k => $v) {
            $sql = $sql . "$k = '$v',";
            echo "$k"."=>"."$v"."<br/>";
        }

        //TODO: 需要修改where条件为动态条件
        $sql = rtrim($sql, ',')." where news_id = 4;";
        echo $sql;
        $conn->query($sql);
        $conn->close();

    }

    /**
     * 方法处理 对 /news 路径的 PATCH 方式处理，
     * 更新 news 信息
     * !方法弃用
     * @param String $base_url 此次请求的基准url example:-> http://localhost/project
     * @param array $body 请求体(提交参数域)
     */
    function patch_news($base_url, $body) {

    }
}
?>