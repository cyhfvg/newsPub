<?php
class FileManager {

    function get_file ($base_url, $body) {
        session_start();
        $user_name = $_SESSION['user_name'];
        $dir = dirname(__FILE__)."/../upload"."/$user_name";
        if (file_exists($dir)) {
            if($dh = opendir($dir)) {
                $result = array();
                while (($file = readdir($dh)) !== false) {
                    if($file != "." && $file != "..") {
                        $url = $base_url;
                        $url = $url."/upload"."/$user_name"."/$file";
                        // $result = array(
                        //     "$file" => array(
                        //         "file_url" => $url,
                        //         "file_name" => $file
                        //     )
                        // );
                        $result["$file"] = array(
                            "file_url" => $url,
                            "file_name" => $file
                        );
                    }
                }
                if (isset($result)) {
                    echo json_encode($result);
                }
            }
        }
    }

    function post_file ($base_url, $body) {
        session_start();
        $user_name = $_SESSION['user_name'];
        if ($_FILES['file']['error'] > 0) {
            echo "错误:".$_FILES['file']['error'].'<br/>';
        } else {
            //个人目录不存在，则新建
            if(!file_exists('upload/'."$user_name")) {
                mkdir(dirname(__FILE__)."/../upload/$user_name");
            }
            move_uploaded_file($_FILES['file']['tmp_name'],'upload/'."$user_name/".$_FILES['file']['name']);
        }
        header("Location: $base_url/view/fileManager.html");
    }
}

?>