
$(function(){	
		var register_options = { 
			type: 'POST',
			url: '../api/v1/register.php',
	        success:function(e){
				if(e.status_code == 0){
					alert('注册成功');
					
				}else{
					alert(e.status_msg);
				}              

			},  
	        dataType: 'json',
			error : function(xhr, status, err) {			
				alert("操作失败"+err);
			}
	    }; 
	    $("#register-form").submit(function(){ 
	        $(this).ajaxSubmit(register_options); 
	        return false;   //防止表单自动提交
	    });
		
		
		login_options = {
			type: 'POST',
			url: '../api/v1/login.php',
		    success:function(e){
				if(e.status_code == 0){
					alert('登录成功');
				}else{
					alert(e.status_msg);
				}
			},  
		    dataType: 'json',
			error : function(xhr, status, err) {			
				alert("操作失败"+err);
			}
		}; 
		$("#login-form").submit(function(){ 
		    $(this).ajaxSubmit(login_options); 
		    return false;   //防止表单自动提交
		});
		
		
});

