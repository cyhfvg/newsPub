<?php
//引入数据库操作辅助函数
include_once BASE_PATH.'/util/mysql.php';

/**
 * Review 类 提供关于各种 http 请求的对应处理函数
 * @method get_review(@param String $base_url, @param array $body)
 * @method post_review(@param String $base_url, @param array $body)
 * @method put_review(@param String $base_url, @param array $body)
 * @method patch_review(@param String $base_url, @param array $body)
 */
class Review {

    /**
     * 方法处理 对 /review 路径的 GET 方式处理
     * 获取 review 数据
     * @param String $base_url 此次请求的基准url example:->http://localhost/projectName
     * @param array $body 请求体(提交数据域)
     */
    function get_review($base_url, $body) {
        $conn = get_connection();

        $length = $body['length'];
        $start = ($body['cur_page'] - 1) * $length;
        $news_id = $body['news_id'];

        $sql = "select tb_review.review_id,review_body,review_pub_time
                from tb_review,tb_n_rev,tb_news 
                where tb_news.news_id= tb_n_rev.news_id 
                and tb_n_rev.review_id = tb_review.review_id
                and tb_news.news_id= $news_id
                GROUP BY tb_review.review_id
                order by review_pub_time 
                desc limit $start,$length;";
        $result = $conn->query($sql);

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
     * 方法处理 对 /review 路径的 POST 方式处理
     * 添加 review 数据
     * @param String $base_url 此次请求的基准url example:->http://localhost/projectName
     * @param array $body 请求体(提交数据域)
     */
    function post_review($base_url, $body) {
        $conn = get_connection();
        $sql = "insert into tb_review (review_body, review_pub_time)
            values (?, ?);";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $review_body, $review_pub_time);

            $review_body = $body['review_body'];
            $review_pub_time = $body['review_pub_time'];
            $news_id = $body['news_id'];

            $stmt->execute();
            $stmt->close();

            //返回插入评论的主键
            $sql = "select last_insert_id();";
            $result = $conn->query($sql);
            $review_id = "";
            if ($row = $result->fetch_assoc()) {
                //取出刚插入的评论的自增主键的值
                $review_id = $row['last_insert_id()'];
            }

            //将评论写入 评论-新闻关系表
            $sql = "insert into tb_n_rev (news_id, review_id) values($news_id, $review_id);";
            $conn->query($sql);
        } else {
            $error = $conn->errno . ' ' . $conn->error;
            echo $error . "<br/>";
        }
        $conn->close();
    }

    /**
     * 方法处理 对 /review 路径的 PUT 方式处理
     * 更新 review 数据
     * @param String $base_url 此次请求的基准url example:->http://localhost/projectName
     * @param array $body 请求体(提交数据域)
     */
    function put_review($base_url, $body) {
       $conn = get_connection();
        if (count($body) > 0) {
            $sql = "update tb_review set ";
        }

        foreach($body as $k => $v) {
            $sql = $sql . "$k = '$v',";
            echo "$k"."=>"."$v"."<br/>";
        }

        //TODO: 需要修改where条件为动态条件
        $sql = rtrim($sql, ',')." where review_id = 1;";
        echo $sql;
        $conn->query($sql);
        $conn->close();

    }

    /**
     * !方法弃用
     * 方法处理 对 /review 路径的 PATCH 方式处理
     * 更新 review 数据
     * @param String $base_url 此次请求的基准url example:->http://localhost/projectName
     * @param array $body 请求体(提交数据域)
     */
    function patch_review($base_url, $body) {

    }

}
?>