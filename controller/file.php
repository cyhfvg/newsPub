<?php
class FileManager {

    function get_file ($base_url, $body) {
        //TODO:将cyhfvg替换为用户名
        $dir = dirname(__FILE__)."/../upload"."/cyhfvg";
        if (file_exists($dir)) {
            if($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if($file != "." && $file != "..") {
                        $url = $base_url;
                        $url = $url."/upload"."/cyhfvg"."/$file";
                        $result = array(
                            "$file" => array(
                                "file_url" => $url,
                                "file_name" => $file
                            )
                        );
                        //*传出文件直接url 文件名
                        echo json_encode($result);
                    }
                }
            }
        }
    }

    function post_file ($base_url, $body) {
        if ($_FILES['file']['error'] > 0) {
            echo "错误:".$_FILES['file']['error'].'<br/>';
        } else {
            //个人目录不存在，则新建
            //TODO:将cyhfvg替换为用户名
            if(!file_exists('upload/'."cyhfvg")) {
                mkdir(dirname(__FILE__)."/../upload/cyhfvg");
            }
            move_uploaded_file($_FILES['file']['tmp_name'],'upload/'."cyhfvg/".$_FILES['file']['name']);
        }
    }
}

?>