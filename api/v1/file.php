<?php
	header("Content-Type:application/json;charset=utf-8");
	
	$res = [
		'status_code'=>0,
		'status_msg'=>'',
	];
	
	if(!empty($_FILES)){
		$file = $_FILES['file'];
		$filename = $file['name'];
		$filetmpname = $file['tmp_name'];
		$filetableid = $_POST['fileid'];
		$path = '../../media/'.$filename;
		$name = $_POST['name'];
		
		$db = include "init_db.php";

		$sql = 'insert into file value(null,"'.$name.'",now(),"../media/'.$filename.'",'.$filetableid.');';
		if ($db->query($sql) === TRUE) {
			move_uploaded_file($filetmpname,$path);
		} else {  
			$res['status_code'] = 1;
			$res['status_msg'] =  $db->error;
		}  

		
	}else{
		$res['status_code'] = 1;
		$res['status_msg'] =  '文件上传失败';
	}

	echo json_encode($res);
?>