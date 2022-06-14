<?php
    header("Content-type: text/html;charset=utf-8");
    // $db = @new mysqli("localhost",'root','','books');
    $db = @new mysqli("localhost",'root','','php');

    if($db->connect_errno){
        die("error".$db->connect_error);
    }

    return $db;

?>