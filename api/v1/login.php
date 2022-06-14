<?php
	// reqeust: username,password,
	// resqonse: status_code,status_msg
	
	header("Content-Type:application/json;charset=utf-8");
	
	$res = [
		'status_code'=>0,
		'status_msg'=>'登录成功'
	];
	
	if(isset($_POST['username'])){
		$username = $_POST['username'];
		$pwd = $_POST['password'];
		
		$db = include 'init_db.php';
		$in_user = "select * from user where name='".$username."';";
		$user_from_sql = mysqli_fetch_array(mysqli_query($db,$in_user),MYSQLI_NUM) ;
		if(count((array)$user_from_sql) > 0){
			$sql_user = $user_from_sql[1];
			$sql_pwd = $user_from_sql[2];
			if(password_verify($pwd,$sql_pwd)){
				setcookie('username',$sql_user,time()+3600*10);
				setcookie('password',$sql_pwd,time()+3600*10);
			}else{
				$res['status_code'] = 1;
				$res['status_msg'] = '密码错误';
			}
		}else{
			$res['status_code'] = 1;
			$res['status_msg'] = '没有该用户';
		}
	}else{
		$res['status_code'] = 1;
		$res['status_msg'] = '提交错误';
	}
	
	if($res['status_code'] === 1){
		setcookie('username','');
		setcookie('password','');
	}
	
	echo json_encode($res);
?>