function switchSign(i)
{
	if (i%2 == 0){
		$(".div-signin").addClass('back');
		$(".div-signup").removeClass('back');
		document.title = '注册 - 纽约 - 有你';
		console.log('hello');
	}
	else{
		$(".div-signup").addClass('back');
		$(".div-signin").removeClass('back');
		document.title = '登陆 - 纽约 - 有你';
		console.log'hello');
	}
	
}