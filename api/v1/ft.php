
<?php
	// reqeust: username,password,
	// resqonse: status_code,status_msg
	
	header("Content-Type:application/json;charset=utf-8");
	
	if(isset($_POST['type']) and $_POST['type']==='add'){
		$res = [
			'status_code'=>0,
			'status_msg'=>'添加成功'
		];

		$name = $_POST['name'];
		$len = $_POST['max_length'];
		

		$user_id = include "islogin.php";
		$db = include "init_db.php";
		$sql = "insert into file_table value(null,'".$name."',now(),".$len.",".$user_id.")";
		if ($db->query($sql) === TRUE) {  
		   
		} else {  
			$res['status_code'] = 1;
			$res['status_msg'] =  $db->error;
		}  

	}else{
		$res = [
			'status_code'=>1,
			'status_msg'=>'获取错误!'
		];
	}
	
	echo json_encode($res);
?>

