<?php
    $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    $filename = basename($_FILES["file"]["name"]);
    // echo $filename;
    // $image = time().'.'.$ext;
    if(move_uploaded_file($_FILES["file"]["tmp_name"],__DIR__. ' \\'.$filename)){
        echo $filename;
    }
?>