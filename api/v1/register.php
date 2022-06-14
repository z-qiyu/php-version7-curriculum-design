<?php
	// reqeust: username,password1,password2,
	// resqonse: status_code,status_msg
	
	header("Content-Type:application/json;charset=utf-8");
	
	$res = [
		'status_code'=>0,
		'status_msg'=>'注册成功'
	];
	
	
	if(isset($_POST['username'])){
		$username = $_POST['username'];
		$pwd1 = $_POST['password1'];
		$pwd2 = $_POST['password2'];
		if($pwd1 !== $pwd2){
			$res['status_code'] = 1;
			$res['status_msg']  = '两次密码不一样';
			
		}else{
			$db = include 'init_db.php';
			$in_user = "select name from user where name='".$username."';";
			$user_from_sql = mysqli_fetch_array(mysqli_query($db,$in_user),MYSQLI_NUM) ;
			if(count((array)$user_from_sql) > 0){
				$res['status_code'] = 1;
				$res['status_msg'] = '已有用户';
			}else{
				$sql = "insert into user value(null,'".$username."','".password_hash($pwd1,PASSWORD_DEFAULT)."',now(),false);";
				$retval = mysqli_query( $db, $sql );
				if(! $retval ){
				  $res['status_code'] = 1;
				  $res['status_msg'] = '无法注册: ' . mysqli_error($conn);
				}
			}
			
			
		}
	}else{
		$res['status_code'] = 1;
		$res['status_msg'] = '提交错误';
	}
	echo json_encode($res);
?>