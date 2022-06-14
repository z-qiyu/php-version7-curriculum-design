<?php
header("Content-Type:application/json;charset=utf-8");
	$res = [
		'status_code'=>0,
		'status_msg'=>'OK',
	];
	$i = isset($_GET['get']);
	if(isset($_COOKIE['username']) and isset($_COOKIE['password'])){
		$db = include "init_db.php";
		$sql = 'select * from user where name="'.$_COOKIE['username'].'";';
		$user_from_sql = mysqli_fetch_array(mysqli_query($db,$sql),MYSQLI_NUM) ;
		if(count((array)$user_from_sql) === 0){
			$res['status_code'] = 1;
			$res['status_msg'] = '用户错误,重新登录';
			if($i){
				echo json_encode($res);
			}
			
			return false;
		}else{
			if($user_from_sql[2] === $_COOKIE['password']){
				if($i){
					echo json_encode($res);
				}
				return $user_from_sql[0];
			}else{
				$res['status_code'] = 1;
				$res['status_msg'] = '用户错误,重新登录';
				if($i){
					echo json_encode($res);
				}
				return false;
			}
		}
	}else{
		$res['status_code'] = 1;
		$res['status_msg'] = '用户错误,重新登录';
		if($i){
			echo json_encode($res);
		}
		return false;
	}

?>