<?php
	// reqeust: username,password,
	// resqonse: status_code,status_msg
	
	header("Content-Type:application/json;charset=utf-8");
	
	if(isset($_POST['type']) and $_POST['type']==='add'){
		$res = [
			'status_code'=>0,
			'status_msg'=>'添加成功,等待验证'
		];
		
		$user1 = $_COOKIE['username'];
		$user2 = $_POST['name'];
		
		$db = include 'init_db.php';
		$sql = "select * from user where name='".$user2."';";
		$user_from_sql = mysqli_fetch_array(mysqli_query($db,$sql),MYSQLI_NUM) ;
		if(count((array)$user_from_sql) === 0){
			$res['status_code'] = 1;
			$res['status_msg'] = '用户名不存在';
		}else{
			$user2_id = $user_from_sql[0];
			$user1_id = include "islogin.php";
			if($user2_id == $user1_id){
				$res['status_code'] = 1;
				$res['status_msg'] = '自己不能添加自己';
			}else{
				if($user1_id === false){
					$res['status_code'] = 1;
					$res['status_msg'] = '该用户有误,请重新登录.';
				}else{
					$sql = 'select * from friend where user1_id='.$user1_id.' and user2_id='.$user2_id.';';
					$user_from_sql = mysqli_fetch_array(mysqli_query($db,$sql),MYSQLI_NUM) ;
					if(count((array)$user_from_sql) === 0){
						$sql = "insert into friend value(null,true,false,false,".$user1_id.",".$user2_id.")";
						if ($db->query($sql) === TRUE) {  
						   
						} else {  
							$res['status_code'] = 1;
							$res['status_msg'] =  $db->error;
						}  
					}else{
						$res['status_code'] = 1;
						$res['status_msg'] = '已经添加过了';
					}
					
		
				}
			}
			
		}
	}else if($_GET['type']==='del'){
		$res = [
			'status_code'=>0,
			'status_msg'=>'删除成功'
		];
		$db = include 'init_db.php';
		$sql = "select id from user where name='".$_GET['u1']."';";
		$sql2 = "select id from user where name='".$_GET['u2']."';";
		
		$user_from_sql1 = mysqli_fetch_array(mysqli_query($db,$sql),MYSQLI_NUM)[0] ;
		$user_from_sql2 = mysqli_fetch_array(mysqli_query($db,$sql2),MYSQLI_NUM)[0]  ;
		
		$sql = 'delete from friend  where user2_id in ('.$user_from_sql2.','.$user_from_sql1.') and user1_id in ('.$user_from_sql2.','.$user_from_sql1.');';
		if ($db->query($sql) === TRUE) {
		   
		} else {  
			$res['status_code'] = 1;
			$res['status_msg'] =  $db->error;
		}  
	}else if($_GET['type']==='ver'){
		$res = [
			'status_code'=>0,
			'status_msg'=>'验证成功,以互为好友'
		];
		$db = include 'init_db.php';
		$sql = "select id from user where name='".$_GET['u1']."';";
		$sql2 = "select id from user where name='".$_GET['u2']."';";
		
		$user_from_sql1 = mysqli_fetch_array(mysqli_query($db,$sql),MYSQLI_NUM)[0] ;
		$user_from_sql2 = mysqli_fetch_array(mysqli_query($db,$sql2),MYSQLI_NUM)[0]  ;
		
		$sql = 'update friend set user1_is_ok=true,user2_is_ok=true,is_friend=true where user2_id in ('.$user_from_sql2.','.$user_from_sql1.') and user1_id in ('.$user_from_sql2.','.$user_from_sql1.');';
		if ($db->query($sql) === TRUE) {
		   
		} else {  
			$res['status_code'] = 1;
			$res['status_msg'] =  $db->error;
		}  
		
	}else if($_GET['type']==='ver_no'){
		$res = [
			'status_code'=>0,
			'status_msg'=>'取消验证成功'
		];
		$db = include 'init_db.php';
		$sql = "select id from user where name='".$_GET['u1']."';";
		$sql2 = "select id from user where name='".$_GET['u2']."';";
		
		$user_from_sql1 = mysqli_fetch_array(mysqli_query($db,$sql),MYSQLI_NUM)[0] ;
		$user_from_sql2 = mysqli_fetch_array(mysqli_query($db,$sql2),MYSQLI_NUM)[0]  ;
		
		$sql = 'delete from friend  where user2_id in ('.$user_from_sql2.','.$user_from_sql1.') and user1_id in ('.$user_from_sql2.','.$user_from_sql1.');';
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