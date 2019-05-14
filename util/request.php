<?php
/**
 * 通过建立一个html表单元素进行数据提交，post/get
 * @param string $url 提交至url
 * @param array $data 提交的参数数组
 * @param string $method 提交的方式 post/get 默认post
 * @return string 提交表单的HTML文本
 */
function do_request($url, $data, $method = 'POST') {
    $sHtml = "<form id='requestForm' name='requestForm' action='".$url."' method='".$method."' enctype='application/json'>";
    // 将参数信息 写入input中 name=key，value=value
    while (list ($key, $val) = each ($data)) {
        $sHtml.="<input type='hidden' name='".$key."' value='".$val."' />";
    }
    //写一个提交按钮
    $sHtml = $sHtml."<input type='submit' value='确定' style='display:none;'></form>";
    //写一个script 自动提交表单
    $sHtml = $sHtml."<script>document.getElementById('requestForm').submit();</script>";
    echo $sHtml;
    return $sHtml;
}

function do_curl_request($url, $data, $method = 'POST') {
    if (strtoupper($method) == 'POST') {
        do_curl_post_request($url, $data);
    } else if (strtoupper($method) == 'GET') {
        do_curl_get_request($url, $data);
    }
}

function do_curl_post_request($url, $data) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POST, 1);
    //设置json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    return $response;
}

function do_curl_get_request($url, $data) {
    $ch = curl_init($url);
    $headers = array (
        'Accept: application/json',
        'Content-Type: application/json',
    );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt( $handle, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    return $response;
}
?>