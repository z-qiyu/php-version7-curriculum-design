<?php
	header("Content-Type:application/json;charset=utf-8");
	$res = [
		'status_code'=>0,
		'status_msg'=>'',
		'files' =>[],
	];

	$islogin = include "islogin.php";
	$id = $_POST['id'];
	if($islogin!==false){
		$db = include "init_db.php";
		$sql = 'select * from file where filetable_id='.$id.';';
		$data = mysqli_query($db,$sql);
		while($file_from_sql = mysqli_fetch_array($data,MYSQLI_ASSOC) ){
			$res['files'][] = [
				'id'=>$file_from_sql['id'],
				'name'=>$file_from_sql['name'],
				'create_time'=>$file_from_sql['create_time'],
				'urlpath'=>$file_from_sql['urlpath'],
				'filetable_id'=>$file_from_sql['filetable_id'],
			];
		}
	}else{
		$res['status_code'] = 1;
		$res['status_msg'] = '您未登录';
		
	}
	if(! isset($res['files'])){
		$res['files'] = [];
	}
	echo json_encode($res);
?>