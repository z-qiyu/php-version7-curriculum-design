<?php
	header("Content-Type:application/json;charset=utf-8");
	
	$res = [
		'status_code'=>0,
		'status_msg'=>'共享成功',
	];
	$islogin = include "islogin.php";
	$nameid = $_POST['to_user'];
	$fileid = $_POST['fileid'];
	if($islogin==false){
		$res['status_code'] = 1;
		$res['status_msg'] = '您未登录';
	}else{
		$db = include "init_db.php";
		$sql = 'select * from share where filetable_id='.$fileid.' and to_user_id='.$nameid.' ';
		$share_from_sql = mysqli_fetch_array(mysqli_query($db,$sql),MYSQLI_NUM);
		if(count((array)$share_from_sql) === 0){
			$sql = 'insert into share value(null,'.$fileid.','.$nameid.');';
			if ($db->query($sql) === TRUE) {
			   
			} else {  
				$res['status_code'] = 1;
				$res['status_msg'] =  $db->error;
			}  
		}else{
			$res['status_code'] = 1;
			$res['status_msg'] = '已经共享过了';
		}
		
	}
	
	
	echo json_encode($res);
?>