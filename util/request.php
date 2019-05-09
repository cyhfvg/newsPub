<?php
/**
 * 通过建立一个html表单元素进行数据提交，post/get
 * @param string $url 提交至url
 * @param array $data 提交的参数数组
 * @param string $method 提交的方式 post/get 默认post
 * @return string 提交表单的HTML文本
 */
function do_request($url, $data, $method = 'POST') {
    $sHtml = "<form id='requestForm' name='requestForm' action='".$url."' method='".$method."'>";
    // 将参数信息 写入input中 name=key，value=value
    while (list ($key, $val) = each ($data)) {
        $sHtml.="<input type='hidden' name='".$key."' value='".$val."' />";
    }
    //写一个提交按钮
    $sHtml = $sHtml."<input type='submit' value='确定' style='display:none;'></form>";
    //写一个script 自动提交表单
    // $sHtml = $sHtml."<script>document.forms['requestForm'].submit();</script>";
    $sHtml = $sHtml."<script>document.getElementById('requestForm').submit();</script>";
    echo $sHtml;
    return $sHtml;
}
?>