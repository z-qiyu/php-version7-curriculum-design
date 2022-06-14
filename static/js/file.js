
function getUrlParams(key) {
	var url = window.location.search.substr(1);
	if (url == '') {
		return false;
	}
	var paramsArr = url.split('&');
	for (var i = 0; i < paramsArr.length; i++) {
		var combina = paramsArr[i].split("=");
		if (combina[0] == key) {
			return combina[1];
		}
	}
	return false;
}


const id = getUrlParams('id');

$('.fileform').append('<input name="fileid" type="hidden" value='+id+' />')

$('.fileform1').append('<input name="fileid" type="hidden" value='+id+' />')

$.post(
	'../api/v1/getfriends.php',
	{},
	function(e){
		e = JSON.parse(e);
		for(var i=0;i<e.friends.length;i++){
			$('select').append('<option value="'+e.friends[i].otherid+'">'+e.friends[i].other+'</option>');
		}
		
	}
)

$.post(
	'../api/v1/iscanshare.php',
	{'id':id},
	function(e){
		e = JSON.parse(e);
		if(e.is=='0'){
			$('.fileform').html('<span>该filetable为共享</span>')
		}
	}
	
)

$.post(
	'../api/v1/getfiles.php',
	{'id':id},
	function(e){
		e = JSON.parse(e);
		for(var i=0;i<e.files.length;i++){
			$('.files>.items').append('<div class="filetables-item" data-href="'+e.files[i].urlpath+'">	<img src="../static/imgs/item.jpg">	<div class="filetables-content">'+e.files[i].name+'</div>	</div>');
		}
		$('.filetables-item').click(function(){
			console.log(this)
			console.log($(this).attr('data-href'))
			location.href = $(this).attr('data-href');
		})
	}
	
)


$('#loadfile').click(function(e){
	$('.upload>form>input[type="file"]').click()
	setInterval(function(){
		$('#loadfile').text($('.upload>form>input[type="file"]').val());
	}, 1000)
})

var share_options = { 
	type: 'POST',
	url: '../api/v1/share.php',
	success:function(e){
		if(e.status_code == 0){
			alert('共享成功');
			
		}else{
			alert(e.status_msg);
		}              

	},  
	dataType: 'json',
	error : function(xhr, status, err) {			
		alert("操作失败"+err);
	}
}; 
$(".fileform").submit(function(){ 
	if($('#share_user').val() ==='0'){
		alert('未选择好友');
	}else{
		$(this).ajaxSubmit(share_options); 
	}
	
	return false;   //防止表单自动提交
});
