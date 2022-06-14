


$(function(){
		$.post(
			'../api/v1/getfriends.php',
			{},
			function(e){
				e = JSON.parse(e);
				$('.firends>.msg-table-content').html('');
				for(var i=0;i<e.friends.length;i++){
					$('.firends>.msg-table-content').append('<div class="firends-item">\
					<span>'+e.friends[i].user2+'</span>'+
					(e.friends[i].is_friend=='1' ? '<a href="#" data-href="../api/v1/friend.php?type=del&u1='+e.friends[i].user1+'&u2='+e.friends[i].user2+'">删除好友</a>' : 
					(e.friends[i].is_you=='1' ? '<a class="a_ok" href="#" data-href="../api/v1/friend.php?type=ver&u1='+e.friends[i].user1+'&u2='+e.friends[i].user2+'">验证同意</a>'+'<a href="#" data-href="../api/v1/friend.php?type=ver_no&u1='+e.friends[i].user1+'&u2='+e.friends[i].user2+'">验证不同意</a>' : "<span>等待验证</span>" ) )
					+'</div>');
				}
				
				$('.firends-item>a').click(function(e){
					tag = $(this);
					$.post(
						tag.attr('data-href'),
						{},
						function(e){
							e=JSON.parse(e);
							if(e.status_code == 0){
								alert('成功');
								window.location.reload();
							}else{
								alert('错误:'+e.status_msg);
							}
						}
					)
				})
				
			}
		)
		$.post(
			'../api/v1/getfiletables.php',
			{},
			function(e){
				e = JSON.parse(e);
				
				$('.filetables>.msg-table-content').html('');
				for(var i=0;i<e.myfiletable.length;i++){
					$('.filetables>.msg-table-content').append('\
					<div class="filetables-item" data-id="files.html?id='+e.myfiletable[i].id+'">\
						<img src="../static/imgs/item.jpg">\
						<div class="filetables-content">'+e.myfiletable[i].name+'</div>\
					</div>');
				}
				
				$('.share>.msg-table-content').html('');
				for(var i=0;i<e.sharefiletable.length;i++){
					$('.share>.msg-table-content').append('\
					<div class="filetables-item" data-id="files.html?id='+e.sharefiletable[i].id+'">\
						<img src="../static/imgs/item.jpg">\
						<div class="filetables-content">'+e.sharefiletable[i].name+'</div>\
					</div>');
				}
				
				$('.sharetables-item').click(function(e){
					tag = $(this);
					location.href = tag.attr('data-id');
				})
				
				$('.filetables-item').click(function(e){
					tag = $(this);
					location.href = tag.attr('data-id');
				})
			}
		)
		
		$.get(
			'../api/v1/islogin.php?get=get',
			{},
			function(e){
				e=JSON.parse(e);
				if(e.status_code == 0){
					;
				}else{
					alert("登录失效，重新登录");
				}
			}
		)
		
		
		$('#addfriend').click(function(){

		    username =prompt("请输入添加用户的用户名");
			if(username!=null){
				$.post(
					'../api/v1/friend.php',
					{
						type:'add',
						name:username
					},
					function(e){
						e=JSON.parse(e);
						if(e.status_code == 0){
							alert('添加成功,等待验证');
						}else{
							alert('错误:'+e.status_msg);
						}
					}
				)
			}   

		})
		$('.logout').click(function(){
			$.get(
				'../api/v1/logout.php',
				{

				},
				function(e){

					alert('退出登陆');
					window.location.reload();
					
				}
			)
		})
		
		$('.createfiletable').click(function(e){
			if(e.target === e.currentTarget){
				$('.createfiletable').css('display','none');
			}
			
		})
		
		$('#create').click(function(){
			$('.createfiletable').removeAttr('style');
		})
		
		var ft_options = {
			type: 'POST',
			url: '../api/v1/ft.php',
		    success:function(e){
				if(e.status_code == 0){
					alert('创建成功');
					window.location.reload();
				}else{
					alert(e.status_msg);
				}              
		
			},  
		    dataType: 'json',
			error : function(xhr, status, err) {			
				alert("操作失败");
			}
		}; 
		$("#ft-form").submit(function(){ 
		    $(this).ajaxSubmit(ft_options); 
		    return false;   //防止表单自动提交
		});
		
})
