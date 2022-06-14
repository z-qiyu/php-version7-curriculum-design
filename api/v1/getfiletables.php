<?php
	header("Content-Type:application/json;charset=utf-8");

	$res = [
		'status_code'=>0,
		'status_msg'=>'',
		'myfiletable' =>[],
		'sharefiletable' =>[],
	];

	$islogin = include "islogin.php";

	if($islogin!==false){
		$db = include "init_db.php";
		$sql = 'select * from file_table where  user_id='.$islogin.';';
		$data = mysqli_query($db,$sql);
		while($filet_from_sql = mysqli_fetch_array($data,MYSQLI_ASSOC) ){
			$res['myfiletable'][] = [
				'id'=>$filet_from_sql['id'],
				'name'=>$filet_from_sql['name'],
				'create_time'=>$filet_from_sql['create_time'],
				'max_length'=>$filet_from_sql['max_length'],
				'user_id'=>$filet_from_sql['user_id'],
			];
		}
		
		$sql = 'select filetable_id from share where  to_user_id='.$islogin.';';
		$data = mysqli_query($db,$sql);
		while($share_from_sql = mysqli_fetch_array($data,MYSQLI_ASSOC) ){
			
			$sql = 'select * from file_table where id='.$share_from_sql['filetable_id'].';';
			
			$filet_from_sql = mysqli_fetch_array(mysqli_query($db,$sql),MYSQLI_ASSOC);
			
			$res['sharefiletable'][] = [
				'id'=>$filet_from_sql['id'],
				'name'=>$filet_from_sql['name'],
				'create_time'=>$filet_from_sql['create_time'],
				'max_length'=>$filet_from_sql['max_length'],
				'user_id'=>$filet_from_sql['user_id'],
			];
		}
		
	}else{
		$res['status_code'] = 1;
		$res['status_msg'] = '您未登录';
		
	}
	if(! isset($res['sharefiletable'])){
		$res['sharefiletable'] = [];
	}
	if(! isset($res['myfiletable'])){
		$res['myfiletable'] = [];
	}
	echo json_encode($res);

?>

