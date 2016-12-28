function switchSign(i){
	if (i%2 == 0){
		$(".div-signin").addClass('back');
		$(".div-signup").removeClass('back');
		document.title = '注册 - FCBS-2014 春节晚会';
	}
	else{
		$(".div-signup").addClass('back');
		$(".div-signin").removeClass('back');
		document.title = '登陆 - FCBS-2014 春节晚会';
	}
	
}