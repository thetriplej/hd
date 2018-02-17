<?php
// default redirection
$url = 'callback.html?callback_func='.$_REQUEST["callback_func"];

$upload_file    = $_FILES['attachFile']['name'];
$upload_tmp        = $_FILES['attachFile']['tmp_name'];
$upload_type    = $_FILES['attachFile']['type'];

$fCnt = count($upload_file);

for($i=0;$i<$fCnt;$i++)
{
    $bSuccessUpload = is_uploaded_file($_FILES['attachFile']['tmp_name']);
    $today = date('Y-m');
// SUCCESSFUL
    if(bSuccessUpload) {
        $tmp_name = $_FILES['attachFile']['tmp_name'];
        $name = $_FILES['attachFile']['name'];

        $filename_ext = strtolower(array_pop(explode('.',$name)));
        $allow_file = array("jpg", "png", "bmp", "gif");

        if(!in_array($filename_ext, $allow_file)) {
            $url .= '&errstr='.$name;
        } else {
            $uploadDir = '/public_html/upload/upload2/'.$today;
            if(!is_dir($uploadDir)){
                mkdir($uploadDir, 0777);
            }

            $newPath = $uploadDir.urlencode($_FILES['attachFile']['name']);

            @move_uploaded_file($tmp_name, $newPath);

            $url .= "&bNewLine=true";
            $url .= "&sFileName=".urlencode(urlencode($name));
            $url .= "&sFileURL=/public_html/upload/upload2/".$today."/".urlencode(urlencode($name));
        }
    }
// FAILED
    else {
        $url .= '&errstr=error';
    }
}

header('Location: '. $url);
?>