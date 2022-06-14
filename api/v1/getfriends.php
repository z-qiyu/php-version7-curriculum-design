<?php
	header("Content-Type:application/json;charset=utf-8");
	$res = [
		'status_code'=>0,
		'status_msg'=>'',
		'friends' =>[],
	];

	$islogin = include "islogin.php";
	
	if($islogin!==false){
		$db = include "init_db.php";
		$sql = 'select * from friend where user1_id='.$islogin.' or user2_id='.$islogin.';';
		$data = mysqli_query($db,$sql);
		while($user_from_sql = mysqli_fetch_array($data,MYSQLI_ASSOC) ){
			$user1 = mysqli_fetch_array(mysqli_query($db,'select name,id from user where id='.$user_from_sql['user1_id'].';'),MYSQLI_NUM);
			$user2 = mysqli_fetch_array(mysqli_query($db,'select name,id from user where id='.$user_from_sql['user2_id'].';'),MYSQLI_NUM);
			$isyou = ($islogin===$user1[0] and $user_from_sql['user2_is_ok']==='1') or ($islogin===$user2[0] and $user_from_sql['user1_is_ok']==='1');
			$res['friends'][] = [
				'user1'=>$user1[0],
				'user2'=>$user2[0],
				'is_friend'=>$user_from_sql['is_friend'],
				'user2_is_ok'=>$user_from_sql['user2_is_ok'],
				'user1_is_ok'=>$user_from_sql['user1_is_ok'],
				'self'=>($user1[1]===$islogin ? $user1[0] : $user2[0]),
				'other'=>($user1[1]===$islogin ? $user2[0] : $user1[0]),
				'otherid'=>($user1[1]===$islogin ? $user2[1] : $user1[1]),
				'is_you'=>$isyou ? '1' : '0',
			];
		}
	}else{
		$res['status_code'] = 1;
		$res['status_msg'] = '您未登录';
		
	}
	echo json_encode($res);
?>