<?php

	header("Content-Type:application/json;charset=utf-8");

	$res = [
		'status_code'=>0,
		'status_msg'=>'',
		'is' =>'0',
	];
	
	$id = $_POST['id'];

	
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
			
			$islogin= false;
		}else{
			if($user_from_sql[2] === $_COOKIE['password']){
				if($i){
					echo json_encode($res);
				}
				$islogin= $user_from_sql[0];
			}else{
				$res['status_code'] = 1;
				$res['status_msg'] = '用户错误,重新登录';
				if($i){
					echo json_encode($res);
				}
				$islogin= false;
			}
		}
	}else{
		$res['status_code'] = 1;
		$res['status_msg'] = '用户错误,重新登录';
		if($i){
			echo json_encode($res);
		}
		$islogin= false;
	}
	
	
	
	$db = include "init_db.php";
	$sql = 'select * from file_table where id='.$id.' and  user_id='.$islogin.' ';
	$share_from_sql = mysqli_fetch_array(mysqli_query($db,$sql),MYSQLI_NUM);
	if(count((array)$share_from_sql) === 0){
		;
	}else{
		$res['is'] = '1';
	}
		
	echo json_encode($res);

?>